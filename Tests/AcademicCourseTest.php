<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/AcademicCourse/AcademicCourse.php';
include_once '../Models/AcademicCourse/AcademicCourseDAO.php';
include_once '../Models/Common/DAOException.php';

final class AcademicCourseTest extends TestCase
{
    protected static $academicCourseDAO;
    protected static $exampleAcademicCourse;
    protected static $exampleAcademicCourseArray;

    public static function setUpBeforeClass(): void
    {
        self::$academicCourseDAO = new AcademicCourseDAO();
        self::$exampleAcademicCourse = new AcademicCourse(NULL, '18/19',2018, 2019);
        self::$exampleAcademicCourseArray = array(
            'submit' => true,
            'id_academic_course' => 1,
            'academic_course_abbr' => '18/19',
            'start_year' => 2018,
            'end_year' => 2019,
        );
    }

    protected function tearDown(): void
    {
        try {
            self::$academicCourseDAO->delete('id_academic_course', 1);
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
        $academicCourseCreated = self::$academicCourseDAO->show('id_academic_course', 1);
        $this->assertInstanceOf(AcademicCourse::class, $academicCourseCreated);
    }

    public function testCanBeUpdated()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        $academicCourse->setAcademicCourseAbbr($academicCourse->formatAbbr(2011,2012));
        $academicCourse->setStartYear(2011);
        $academicCourse->setEndYear(2012);
        self::$academicCourseDAO->edit($academicCourse);
        $academicCourseCreated = self::$academicCourseDAO->show('id_academic_course', 1);
        $this->assertEquals($academicCourseCreated->getStartYear(), 2011);
    }

    public function testCanBeDeleted()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        self::$academicCourseDAO->delete('id_academic_course', 1);

        $this->expectException(DAOException::class);
        $academicCourseCreated = self::$academicCourseDAO->show('id_academic_course', 1);
    }

    public function testCanShowNone()
    {
        $academicCourseCreated = self::$academicCourseDAO->showAll('id_academic_course', '_test');
        $this->assertEmpty($academicCourseCreated);
    }

    public function testCanShowSeveral()
    {
        $academicCourse1 = clone self::$exampleAcademicCourse;
        $academicCourse1->setIdAcademicCourse(1);
        $academicCourse2 = clone self::$exampleAcademicCourse;
        $academicCourse2->setIdAcademicCourse(2);
        $academicCourse3 = clone self::$exampleAcademicCourse;
        $academicCourse3->setIdAcademicCourse(3);

        self::$academicCourseDAO->add($academicCourse1);
        self::$academicCourseDAO->add($academicCourse2);
        self::$academicCourseDAO->add($academicCourse3);

        $academicCoursesCreated = self::$academicCourseDAO->showAll("start_year", 2018);

        $this->assertTrue($academicCoursesCreated[0]->getIdAcademicCourse() == 1);
        $this->assertTrue($academicCoursesCreated[1]->getIdAcademicCourse() == 2);
        $this->assertTrue($academicCoursesCreated[2]->getIdAcademicCourse() == 3);

        self::$academicCourseDAO->delete('id_academic_course', 'test1');
        self::$academicCourseDAO->delete('id_academic_course', 'test2');
        self::$academicCourseDAO->delete('id_academic_course', 'test3');
    }

    public function testIntCanBeCreated()
    {
        $postData = self::$exampleAcademicCourseArray;
        self::curlPost($postData, 'add');
        $academicCourseCreated = self::$academicCourseDAO->show('id_academic_course', 1);
        $this->assertInstanceOf(AcademicCourse::class, $academicCourseCreated);
    }

    public function testIntCanBeUpdated()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        $postData = self::$exampleAcademicCourseArray;
        $postData['start_year'] = 2011;
        self::curlPost($postData, "edit");
        $academicCourseCreated = self::$academicCourseDAO->show('id_academic_course', 1);
        $this->assertEquals(2011, $academicCourseCreated->getStartYear());
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
        $academicCourseCreated = self::$academicCourseDAO->show('id_academic_course', 1);
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
