<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/Teacher/Teacher.php';
include_once '../Models/User/User.php';
include_once '../Models/Space/Space.php';
include_once '../Models/Building/Building.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class TeacherTest extends TestCase
{
    protected static $teacherDAO;
    protected static $userDAO;
    protected static $exampleTeacher;

    public static function setUpBeforeClass(): void
    {
        initTestDB();

        self::$teacherDAO = new TeacherDAO();
        self::$userDAO = new UserDAO();
        $spaceDAO = new SpaceDAO();
        $buildingDAO = new BuildingDAO();

        $user1 = new User('_test_1', 'test_pass', '11111111A', 'test', 'test teacher', 'test@example.com',
            'calle falsa 123', '666444666');
        $user2 = new User('_test_2', 'test_pass', '11111111A', 'test', 'test teacher', 'test@example.com',
            'calle falsa 123', '666444666');
        $user3 = new User('_test_3', 'test_pass', '11111111A', 'test', 'test teacher', 'test@example.com',
            'calle falsa 123', '666444666');
        self::$userDAO->add($user1);
        self::$userDAO->add($user2);
        self::$userDAO->add($user3);

        $building = new Building(1, 'Edificio de Físicas', 'Ourense', $user1);
        $buildingDAO->add($building);

        $space = new Space(1, 'Despacho 300', $building, 30);
        $spaceDAO->add($space);

        self::$exampleTeacher = new Teacher(1, $user1, 'Full', $space);
    }

    protected function tearDown(): void
    {
        try {
            self::$teacherDAO->delete('id', 1);
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
        $teacher = clone self::$exampleTeacher;
        $this->assertInstanceOf(
            Teacher::class,
            $teacher
        );
    }

    public function testCanBeAdded()
    {
        $teacher = clone self::$exampleTeacher;
        self::$teacherDAO->add($teacher);
        $teacherCreated = self::$teacherDAO->show("id", 1);
        $this->assertInstanceOf(Teacher::class, $teacherCreated);
    }

    public function testCanBeUpdated()
    {
        $teacher = clone self::$exampleTeacher;
        self::$teacherDAO->add($teacher);
        $teacher->setDedication("Mid");
        self::$teacherDAO->edit($teacher);
        $teacherCreated = self::$teacherDAO->show("id", 1);
        $this->assertEquals($teacherCreated->getDedication(), "Mid");
    }

    public function testCanBeDeleted()
    {
        $teacher = clone self::$exampleTeacher;
        self::$teacherDAO->add($teacher);
        self::$teacherDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $teacherCreated = self::$teacherDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $teacherCreated = self::$teacherDAO->showAll("id", 1);
        $this->assertEmpty($teacherCreated);
    }

    public function testCanShowSeveral()
    {
        $teacher1 = clone self::$exampleTeacher;
        $teacher1->setId(2);
        $teacher2 = clone self::$exampleTeacher;
        $teacher2->setId(3);
        $teacher2->setUser(self::$userDAO->show('login','_test_2'));
        $teacher3 = clone self::$exampleTeacher;
        $teacher3->setId(4);
        $teacher3->setUser(self::$userDAO->show('login','_test_3'));


        self::$teacherDAO->add($teacher1);
        self::$teacherDAO->add($teacher2);
        self::$teacherDAO->add($teacher3);

        $teachersCreated = self::$teacherDAO->showAll("dedication", "Full");

        $this->assertTrue(count($teachersCreated) == 3);
    }
}
