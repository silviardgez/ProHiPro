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
        self::$exampleAcademicCourse = new AcademicCourse('_test', 2018, 2019);
        self::$exampleAcademicCourseArray = array(
            'submit' => true,
            'IdAcademicCourse' => '_test',
            'start_year' => 2018,
            'end_year' => 2019,
        );
    }

    protected function tearDown(): void
    {
        try {
            self::$academicCourseDAO->delete('IdAcademicCourse', '_test');
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
        $academicCourseCreated = self::$academicCourseDAO->show('IdAcademicCourse', '_test');
        $this->assertInstanceOf(AcademicCourse::class, $academicCourseCreated);
    }

    public function testCanBeUpdated()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        $academicCourse->setStartYear(2011);
        self::$academicCourseDAO->edit($academicCourse);
        $academicCourseCreated = self::$academicCourseDAO->show('IdAcademicCourse', '_test');
        $this->assertEquals($academicCourseCreated->getStartYear(), 2011);
    }

    public function testCanBeDeleted()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        self::$academicCourseDAO->delete('IdAcademicCourse', '_test');

        $this->expectException(DAOException::class);
        $academicCourseCreated = self::$academicCourseDAO->show('IdAcademicCourse', '_test');
    }

    public function testCanShowNone()
    {
        $academicCourseCreated = self::$academicCourseDAO->showAll('IdAcademicCourse', '_test');
        $this->assertEmpty($academicCourseCreated);
    }

    public function testCanShowSeveral()
    {
        $academicCourse1 = clone self::$exampleAcademicCourse;
        $academicCourse1->setIdAcademicCourse('test1');
        $academicCourse2 = clone self::$exampleAcademicCourse;
        $academicCourse2->setIdAcademicCourse('test2');
        $academicCourse3 = clone self::$exampleAcademicCourse;
        $academicCourse3->setIdAcademicCourse('test3');

        self::$academicCourseDAO->add($academicCourse1);
        self::$academicCourseDAO->add($academicCourse2);
        self::$academicCourseDAO->add($academicCourse3);

        $academicCoursesCreated = self::$academicCourseDAO->showAll("start_year", 2018);

        $this->assertTrue($academicCoursesCreated[0]->getIdAcademicCourse() == 'test1');
        $this->assertTrue($academicCoursesCreated[1]->getIdAcademicCourse() == 'test2');
        $this->assertTrue($academicCoursesCreated[2]->getIdAcademicCourse() == 'test3');

        self::$academicCourseDAO->delete('IdAcademicCourse', 'test1');
        self::$academicCourseDAO->delete('IdAcademicCourse', 'test2');
        self::$academicCourseDAO->delete('IdAcademicCourse', 'test3');
    }

    public function testIntCanBeCreated()
    {
        $postData = self::$exampleAcademicCourseArray;
        self::curlPost($postData, 'add');
        $academicCourseCreated = self::$academicCourseDAO->show('IdAcademicCourse', '_test');
        $this->assertInstanceOf(AcademicCourse::class, $academicCourseCreated);
    }

    public function testIntCanBeUpdated()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        $postData = self::$exampleAcademicCourseArray;
        $postData['start_year'] = 2011;
        self::curlPost($postData, "edit");
        $academicCourseCreated = self::$academicCourseDAO->show('IdAcademicCourse', '_test');
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
            "http://localhost/Controllers/AcademicCourseController.php?action=delete&IdAcademicCourse=_test&confirm=true"
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);

        $this->expectException(DAOException::class);
        $academicCourseCreated = self::$academicCourseDAO->show('IdAcademicCourse', '_test');
    }

    private function curlPost($postData, $action)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, "http://localhost/Controllers/AcademicCourseController.php?action=" . $action . "&IdAcademicCourse=_test");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }
}
