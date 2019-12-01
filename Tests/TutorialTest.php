<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/User/User.php';
include_once '../Models/Building/Building.php';
include_once '../Models/Teacher/Teacher.php';
include_once '../Models/Space/Space.php';
include_once '../Models/Tutorial/Tutorial.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/Tutorial/TutorialDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class TutorialTest extends TestCase
{
    protected static $userDAO;
    protected static $spaceDAO;
    protected static $buildingDAO;
    protected static $teacherDAO;
    protected static $tutorialDAO;
    protected static $exampleTutorial;

    public static function setUpBeforeClass(): void
    {
        initTestDB();

        self::$tutorialDAO = new TutorialDAO();
        $userDAO = new UserDAO();
        $spaceDAO = new SpaceDAO();
        $buildingDAO = new BuildingDAO();
        $teacherDAO = new TeacherDAO();

        $user = new User('_test_', 'test_pass', '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        $userDAO->add($user);

        $building = new Building(3, 'Edificio de Físicas', 'Ourense', $user);
        $buildingDAO->add($building);

        $space = new Space(1, 'Despacho 300', $building, 30);
        $spaceDAO->add($space);

        $teacher = new Teacher(1, $user, 'Full', $space);
        $teacherDAO->add($teacher);

        self::$exampleTutorial = new Tutorial(1, $teacher, $space, 3);
    }

    protected function tearDown(): void
    {
        try {
            self::$tutorialDAO->delete('id', 1);
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
        $tutorial = clone self::$exampleTutorial;
        $this->assertInstanceOf(
            Tutorial::class,
            $tutorial
        );
    }

    public function testCanBeAdded()
    {
        $tutorial = clone self::$exampleTutorial;
        self::$tutorialDAO->add($tutorial);
        $tutorialCreated = self::$tutorialDAO->show("id", 1);
        $this->assertInstanceOf(Tutorial::class, $tutorialCreated);
    }

    public function testCanBeUpdated()
    {
        $tutorial = clone self::$exampleTutorial;
        self::$tutorialDAO->add($tutorial);
        $tutorial->setTotalHours(2);
        self::$tutorialDAO->edit($tutorial);
        $tutorialCreated = self::$tutorialDAO->show("id", 1);
        $this->assertEquals($tutorialCreated->getTotalHours(), 2);
    }

    public function testCanBeDeleted()
    {
        $tutorial = clone self::$exampleTutorial;
        self::$tutorialDAO->add($tutorial);
        self::$tutorialDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $tutorialCreated = self::$tutorialDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $tutorialCreated = self::$tutorialDAO->showAll();
        $this->assertEmpty($tutorialCreated);
    }

    public function testCanShowSeveral()
    {
        $tutorial1 = clone self::$exampleTutorial;
        $tutorial1->setId(2);
        $tutorial1->setTotalHours(4);
        $tutorial2 = clone self::$exampleTutorial;
        $tutorial2->setId(3);
        $tutorial2->setTotalHours(5);
        $tutorial3 = clone self::$exampleTutorial;
        $tutorial3->setId(4);
        $tutorial3->setTotalHours(6);


        self::$tutorialDAO->add($tutorial1);
        self::$tutorialDAO->add($tutorial2);
        self::$tutorialDAO->add($tutorial3);

        $tutorialsCreated = self::$tutorialDAO->showAll();

        $this->assertTrue(count($tutorialsCreated) == 3);
    }
}
