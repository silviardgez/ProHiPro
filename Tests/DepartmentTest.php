<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/User/User.php';
include_once '../Models/Building/Building.php';
include_once '../Models/Teacher/Teacher.php';
include_once '../Models/Space/Space.php';
include_once '../Models/Department/Department.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/Department/DepartmentDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class DepartmentTest extends TestCase
{
    protected static $userDAO;
    protected static $spaceDAO;
    protected static $buildingDAO;
    protected static $teacherDAO;
    protected static $departmentDAO;
    protected static $exampleDepartment;

    public static function setUpBeforeClass(): void
    {
        initTestDB();

        self::$departmentDAO = new DepartmentDAO();
        self::$userDAO = new UserDAO();
        self::$spaceDAO = new SpaceDAO();
        self::$buildingDAO = new BuildingDAO();
        self::$teacherDAO = new TeacherDAO();

        $user = new User('_test_', 'test_pass', '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        self::$userDAO->add($user);

        $building = new Building(3, 'Edificio de Físicas', 'Ourense', $user);
        self::$buildingDAO->add($building);

        $space = new Space(1, 'Despacho 300', $building, 30);
        self::$spaceDAO->add($space);

        $teacher = new Teacher(1, $user, 'Full', $space);
        self::$teacherDAO->add($teacher);

        self::$exampleDepartment = new Department(1, 'D01', 'Informática', $teacher);
    }

    protected function tearDown(): void
    {
        try {
            self::$departmentDAO->delete('id', 1);
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
        $department = clone self::$exampleDepartment;
        $this->assertInstanceOf(
            Department::class,
            $department
        );
    }

    public function testCanBeAdded()
    {
        $department = clone self::$exampleDepartment;
        self::$departmentDAO->add($department);
        $departmentCreated = self::$departmentDAO->show("id", 1);
        $this->assertInstanceOf(Department::class, $departmentCreated);
    }

    public function testCanBeUpdated()
    {
        $department = clone self::$exampleDepartment;
        self::$departmentDAO->add($department);
        $department->setName('Edificio de Informática');
        self::$departmentDAO->edit($department);
        $departmentCreated = self::$departmentDAO->show("id", 1);
        $this->assertEquals($departmentCreated->getName(), 'Edificio de Informática');
    }

    public function testCanBeDeleted()
    {
        $department = clone self::$exampleDepartment;
        self::$departmentDAO->add($department);
        self::$departmentDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $departmentCreated = self::$departmentDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $departmentCreated = self::$departmentDAO->showAll();
        $this->assertEmpty($departmentCreated);
    }

    public function testCanShowSeveral()
    {
        $department1 = clone self::$exampleDepartment;
        $department1->setId(2);
        $department1->setCode('D02');
        $department1->setName('Edificio de física');
        $department2 = clone self::$exampleDepartment;
        $department2->setId(3);
        $department2->setCode('D03');
        $department2->setName('Edificio de derecho');
        $department3 = clone self::$exampleDepartment;
        $department3->setId(4);
        $department3->setCode('D04');
        $department3->setName('Edificio de educación');


        self::$departmentDAO->add($department1);
        self::$departmentDAO->add($department2);
        self::$departmentDAO->add($department3);

        $departmentsCreated = self::$departmentDAO->showAll();

        $this->assertTrue(count($departmentsCreated) == 3);
    }
}
