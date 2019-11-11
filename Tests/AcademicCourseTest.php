<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

require_once '../Models/AcademicCourse/AcademicCourse.php';
require_once '../Models/AcademicCourse/AcademicCourseDAO.php';
require_once '../Models/Common/DAOException.php';

final class AcademicCourseTest extends TestCase
{
    protected static $academicCourseDAO;
    protected static $exampleAcademicCourse;
    protected static $exampleAcademicCourseArray;

    public static function setUpBeforeClass(): void
    {
        self::$academicCourseDAO = new AcademicCourseDAO();
        self::$exampleAcademicCourse = new AcademicCourse(1, '50/51', 2050, 2051);
        self::$exampleAcademicCourseArray = array(
            'submit' => true,
            'id_academic_course' => 1,
            'academic_course_abbr' => '50/51',
            'start_year' => 2050,
            'end_year' => 2051,
        );
    }

    protected function tearDown(): void
    {
        try {
            self::$academicCourseDAO->delete('academic_course_abbr', '50/51');
        } catch (Exception $e) {
        }
    }

    public function testCanBeCreated()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        $this->assertInstanceOf(
            AcademicCourse::class,
            $academicCourse
        );
    }

    public function testCanBeAdded()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        $academicCourseCreated = self::$academicCourseDAO->show('academic_course_abbr', '50/51');
        $this->assertInstanceOf(AcademicCourse::class, $academicCourseCreated);
    }

    public function testCanBeUpdated()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        $academicCourse->setAcademicCourseAbbr($academicCourse->formatAbbr(2051, 2052));
        $academicCourse->setStartYear(2051);
        $academicCourse->setEndYear(2052);
        self::$academicCourseDAO->edit($academicCourse);
        $academicCourseCreated = self::$academicCourseDAO->show('academic_course_abbr', '51/52');
        $this->assertEquals($academicCourseCreated->getStartYear(), 2051);
        self::$academicCourseDAO->delete('academic_course_abbr', '51/52');
    }

    public function testCanBeDeleted()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        self::$academicCourseDAO->delete('academic_course_abbr', '50/51');

        $this->expectException(DAOException::class);
        $academicCourseCreated = self::$academicCourseDAO->show('academic_course_abbr', '50/51');
    }

    public function testCanShowNone()
    {
        $this->expectException(DAOException::class);
        $academicCourseCreated = self::$academicCourseDAO->show('academic_course_abbr', '50/51');
    }

    public function testCanShowSeveral()
    {
        $academicCourse1 = clone self::$exampleAcademicCourse;
        $academicCourse1->setIdAcademicCourse(1);
        $academicCourse1->setAcademicCourseAbbr($academicCourse1->formatAbbr(2051, 2052));
        $academicCourse2 = clone self::$exampleAcademicCourse;
        $academicCourse2->setIdAcademicCourse(2);
        $academicCourse2->setAcademicCourseAbbr($academicCourse2->formatAbbr(2052, 2053));
        $academicCourse3 = clone self::$exampleAcademicCourse;
        $academicCourse3->setIdAcademicCourse(3);
        $academicCourse3->setAcademicCourseAbbr($academicCourse3->formatAbbr(2053, 2054));

        self::$academicCourseDAO->add($academicCourse1);
        self::$academicCourseDAO->add($academicCourse2);
        self::$academicCourseDAO->add($academicCourse3);

        $academicCoursesCreated = self::$academicCourseDAO->showAll();

        $this->assertTrue(count($academicCoursesCreated) >= 3);

        self::$academicCourseDAO->delete('academic_course_abbr', '51/52');
        self::$academicCourseDAO->delete('academic_course_abbr', '52/53');
        self::$academicCourseDAO->delete('academic_course_abbr', '53/54');
    }

    public function testIntCanBeCreated()
    {
        $postData = self::$exampleAcademicCourseArray;
        self::curlPost($postData, 'add');
        $academicCourseCreated = self::$academicCourseDAO->show('academic_course_abbr', '50/51');
        $this->assertInstanceOf(AcademicCourse::class, $academicCourseCreated);
    }

    public function testIntCanBeUpdated()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        $postData = self::$exampleAcademicCourseArray;
        $postData['start_year'] = 2051;
        $postData['end_year'] = 2052;
        self::curlPost($postData, "edit");
        $academicCourseCreated = self::$academicCourseDAO->show('academic_course_abbr', '51/52');
        $this->assertEquals(2051, $academicCourseCreated->getStartYear());
        self::$academicCourseDAO->delete('academic_course_abbr', '51/52');
    }

    public function testIntCanBeDeleted()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch,
            CURLOPT_URL,
            "http://localhost/Controllers/AcademicCourseController.php?action=delete&id_academic_course=1&confirm=true"
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);

        $this->expectException(DAOException::class);
        $academicCourseCreated = self::$academicCourseDAO->show('academic_course_abbr', '50/51');
    }

    private function curlPost($postData, $action)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, "http://localhost/Controllers/AcademicCourseController.php?action=" . $action . "&id_academic_course=1");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }
}
