<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/Center/Center.php';
include_once '../Models/University/University.php';
include_once '../Models/AcademicCourse/AcademicCourse.php';
include_once '../Models/Center/CenterDAO.php';
include_once '../Models/University/UniversityDAO.php';
include_once '../Models/AcademicCourse/AcademicCourseDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class CenterTest extends TestCase
{
    protected static $centerDAO;
    protected static $universityDAO;
    protected static $academicCourseDAO;
    protected static $exampleCenter;
    protected static $exampleCenterArray;

    public static function setUpBeforeClass(): void
    {
        initTestDB();

        self::$centerDAO = new CenterDAO();
        self::$universityDAO = new UniversityDAO();
        self::$academicCourseDAO = new AcademicCourseDAO();
        $acCourse = new AcademicCourse(1, '50/51', 2050, 2051);
        self::$academicCourseDAO->add($acCourse);
        $university1 = new University(1, $acCourse, "Universidade de Vigo");
        $university2 = new University(2, $acCourse, "Universidade de Coruña");
        $university3 = new University(3, $acCourse, "Universidade de Santiago");
        self::$universityDAO->add($university1);
        self::$universityDAO->add($university2);
        self::$universityDAO->add($university3);
        self::$exampleCenter = new Center(1, $university1, 'ESEI', 'Edificio Politécnico');
    }

    protected function tearDown(): void
    {
        try {
            self::$centerDAO->delete('id', 1);
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
        $center = clone self::$exampleCenter;
        $this->assertInstanceOf(
            Center::class,
            $center
        );
    }

    public function testCanBeAdded()
    {
        $center = clone self::$exampleCenter;
        self::$centerDAO->add($center);
        $centerCreated = self::$centerDAO->show("id", 1);
        $this->assertInstanceOf(Center::class, $centerCreated);
    }

    public function testCanBeUpdated()
    {
        $center = clone self::$exampleCenter;
        self::$centerDAO->add($center);
        $center->setUniversity(self::$universityDAO->show("id", 2));
        self::$centerDAO->edit($center);
        $centerCreated = self::$centerDAO->show("id", 1);
        $this->assertEquals($centerCreated->getUniversity()->getId(), 2);
    }

    public function testCanBeDeleted()
    {
        $center = clone self::$exampleCenter;
        self::$centerDAO->add($center);
        self::$centerDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $centerCreated = self::$centerDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $centerCreated = self::$centerDAO->showAll("id", 1);
        $this->assertEmpty($centerCreated);
    }

    public function testCanShowSeveral()
    {
        $center1 = clone self::$exampleCenter;
        $center1->setId(2);
        $center2 = clone self::$exampleCenter;
        $center2->setId(3);
        $center2->setUniversity(new University(2, '51/52', 2051, 2052));
        $center3 = clone self::$exampleCenter;
        $center3->setId(4);
        $center3->setUniversity(new University(3, '52/53', 2052, 2053));


        self::$centerDAO->add($center1);
        self::$centerDAO->add($center2);
        self::$centerDAO->add($center3);

        $universitiessCreated = self::$centerDAO->showAll();

        $this->assertTrue($universitiessCreated[0]->getId() == 2);
        $this->assertTrue($universitiessCreated[1]->getId() == 3);
        $this->assertTrue($universitiessCreated[2]->getId() == 4);
    }
}
