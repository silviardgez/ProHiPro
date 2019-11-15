<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/University/University.php';
include_once '../Models/AcademicCourse/AcademicCourse.php';
include_once '../Models/University/UniversityDAO.php';
include_once '../Models/AcademicCourse/AcademicCourseDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class UniversityTest extends TestCase
{
    protected static $universityDAO;
    protected static $academicCourseDAO;
    protected static $exampleUniversity;
    protected static $exampleUniversityArray;

    public static function setUpBeforeClass(): void
    {
        initTestDB();

        self::$universityDAO = new UniversityDAO();
        self::$academicCourseDAO = new AcademicCourseDAO();
        $acCourse1 = new AcademicCourse(1, '50/51', 2050, 2051);
        $acCourse2 = new AcademicCourse(2, '51/52', 2051, 2052);
        $acCourse3 = new AcademicCourse(3, '52/53', 2052, 2053);
        self::$academicCourseDAO->add($acCourse1);
        self::$academicCourseDAO->add($acCourse2);
        self::$academicCourseDAO->add($acCourse3);
        self::$exampleUniversity = new University(1, $acCourse1, 'Universidade de Vigo');
    }

    protected function tearDown(): void
    {
        try {
            self::$universityDAO->delete('id', 1);
        } catch (Exception $e) {
        }
    }

    public static function tearDownAfterClass(): void
    {
        try {
            restoreDB();
        } catch (Exception $e) {
        }
    }

    public function testCanBeCreated()
    {
        $university = clone self::$exampleUniversity;
        $this->assertInstanceOf(
            University::class,
            $university
        );
    }

    public function testCanBeAdded()
    {
        $university = clone self::$exampleUniversity;
        self::$universityDAO->add($university);
        $universityCreated = self::$universityDAO->show("id", 1);
        $this->assertInstanceOf(University::class, $universityCreated);
    }

    public function testCanBeUpdated()
    {
        $university = clone self::$exampleUniversity;
        self::$universityDAO->add($university);
        $university->setAcademicCourse(self::$academicCourseDAO->show("id", 2));
        self::$universityDAO->edit($university);
        $universityCreated = self::$universityDAO->show("id", 1);
        $this->assertEquals($universityCreated->getAcademicCourse()->getId(), 2);
    }

    public function testCanBeDeleted()
    {
        $university = clone self::$exampleUniversity;
        self::$universityDAO->add($university);
        self::$universityDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $universityCreated = self::$universityDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $universityCreated = self::$universityDAO->showAll("id", 1);
        $this->assertEmpty($universityCreated);
    }

    public function testCanShowSeveral()
    {
        $university1 = clone self::$exampleUniversity;
        $university1->setId(2);
        $university2 = clone self::$exampleUniversity;
        $university2->setId(3);
        $university2->setAcademicCourse(new AcademicCourse(2, '51/52', 2051, 2052));
        $university3 = clone self::$exampleUniversity;
        $university3->setId(4);
        $university3->setAcademicCourse(new AcademicCourse(3, '52/53', 2052, 2053));


        self::$universityDAO->add($university1);
        self::$universityDAO->add($university2);
        self::$universityDAO->add($university3);

        $universitiessCreated = self::$universityDAO->showAll();

        $this->assertTrue($universitiessCreated[0]->getId() == 2);
        $this->assertTrue($universitiessCreated[1]->getId() == 3);
        $this->assertTrue($universitiessCreated[2]->getId() == 4);
    }
}
