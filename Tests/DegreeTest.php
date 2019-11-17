<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/Degree/Degree.php';
include_once '../Models/University/University.php';
include_once '../Models/User/User.php';
include_once '../Models/Center/Center.php';
include_once '../Models/Building/Building.php';
include_once '../Models/AcademicCourse/AcademicCourse.php';
include_once '../Models/Degree/DegreeDAO.php';
include_once '../Models/University/UniversityDAO.php';
include_once '../Models/AcademicCourse/AcademicCourseDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Center/CenterDAO.php';
include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class DegreeTest extends TestCase
{
    protected static $degreeDAO;
    protected static $universityDAO;
    protected static $buildingDAO;
    protected static $userDAO;
    protected static $academicCourseDAO;
    protected static $centerDAO;
    protected static $exampleDegree;

    public static function setUpBeforeClass(): void
    {
        initTestDB();

        self::$degreeDAO = new DegreeDAO();
        self::$universityDAO = new UniversityDAO();
        self::$academicCourseDAO = new AcademicCourseDAO();
        self::$userDAO = new UserDAO();
        self::$centerDAO = new CenterDAO();
        self::$buildingDAO = new BuildingDAO();
        $acCourse = new AcademicCourse(1, '50/51', 2050, 2051);
        self::$academicCourseDAO->add($acCourse);
        $user = new User('_test_', 'test_pass', '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        self::$userDAO->add($user);
        $university = new University(1, $acCourse, "Universidade de Vigo", $user);
        self::$universityDAO->add($university);
        $building = new Building(1, 'Edificio Politécnico', 'Ourense', $user);
        self::$buildingDAO->add($building);
        $center1 = new Center(1, $university, 'ESEI', $building, $user);
        $center2 = new Center(2, $university, 'Facultad de Ciencias', $building, $user);
        $center3 = new Center(3, $university, 'Facultad de Letras', $building, $user);
        self::$centerDAO->add($center1);
        self::$centerDAO->add($center2);
        self::$centerDAO->add($center3);
        self::$exampleDegree = new Degree(1, 'Ing. Informática', $center1, 120, 'None', 240, $user);
    }

    protected function tearDown(): void
    {
        try {
            self::$degreeDAO->delete('id', 1);
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
        $degree = clone self::$exampleDegree;
        $this->assertInstanceOf(
            Degree::class,
            $degree
        );
    }

    public function testCanBeAdded()
    {
        $degree = clone self::$exampleDegree;
        self::$degreeDAO->add($degree);
        $degreeCreated = self::$degreeDAO->show("id", 1);
        $this->assertInstanceOf(Degree::class, $degreeCreated);
    }

    public function testCanBeUpdated()
    {
        $degree = clone self::$exampleDegree;
        self::$degreeDAO->add($degree);
        $degree->setName("Grado en Ing. Informática");
        self::$degreeDAO->edit($degree);
        $degreeCreated = self::$degreeDAO->show("id", 1);
        $this->assertEquals($degreeCreated->getName(), "Grado en Ing. Informática");
    }

    public function testCanBeDeleted()
    {
        $degree = clone self::$exampleDegree;
        self::$degreeDAO->add($degree);
        self::$degreeDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $degreeCreated = self::$degreeDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $degreeCreated = self::$degreeDAO->showAll();
        $this->assertEmpty($degreeCreated);
    }

    public function testCanShowSeveral()
    {
        $degree1 = clone self::$exampleDegree;
        $degree1->setId(2);
        $degree2 = clone self::$exampleDegree;
        $degree2->setId(3);
        $degree2->setCenter(self::$centerDAO->show('id', 2));
        $degree3 = clone self::$exampleDegree;
        $degree3->setId(4);
        $degree3->setCenter(self::$centerDAO->show('id', 3));


        self::$degreeDAO->add($degree1);
        self::$degreeDAO->add($degree2);
        self::$degreeDAO->add($degree3);

        $universitiessCreated = self::$degreeDAO->showAll();

        $this->assertTrue($universitiessCreated[0]->getId() == 2);
        $this->assertTrue($universitiessCreated[1]->getId() == 3);
        $this->assertTrue($universitiessCreated[2]->getId() == 4);
    }
}
