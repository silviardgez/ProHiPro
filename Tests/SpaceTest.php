<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/Space/Space.php';
include_once '../Models/User/User.php';
include_once '../Models/Building/Building.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class SpaceTest extends TestCase
{
    protected static $spaceDAO;
    protected static $userDAO;
    protected static $buildingDAO;
    protected static $exampleSpace;

    public static function setUpBeforeClass(): void
    {
        initTestDB();

        self::$spaceDAO = new SpaceDAO();
        self::$userDAO = new UserDAO();
        self::$buildingDAO = new BuildingDAO();
        $user = new User('_test_', 'test_pass', '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        self::$userDAO->add($user);
        $building1 = new Building(1, 'Edificio Politécnico', 'Ourense', $user);
        $building2 = new Building(2, 'Edificio de Hierro', 'Ourense', $user);
        $building3 = new Building(3, 'Edificio de Físicas', 'Ourense', $user);
        self::$buildingDAO->add($building1);
        self::$buildingDAO->add($building2);
        self::$buildingDAO->add($building3);
        self::$exampleSpace = new Space(1, 'Laboratorio SO6', $building1, 30);
    }

    protected function tearDown(): void
    {
        try {
            self::$spaceDAO->delete('id', 1);
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
        $space = clone self::$exampleSpace;
        $this->assertInstanceOf(
            Space::class,
            $space
        );
    }

    public function testCanBeAdded()
    {
        $space = clone self::$exampleSpace;
        self::$spaceDAO->add($space);
        $spaceCreated = self::$spaceDAO->show("id", 1);
        $this->assertInstanceOf(Space::class, $spaceCreated);
    }

    public function testCanBeUpdated()
    {
        $space = clone self::$exampleSpace;
        self::$spaceDAO->add($space);
        $space->setBuilding(self::$buildingDAO->show("id", 2));
        self::$spaceDAO->edit($space);
        $spaceCreated = self::$spaceDAO->show("id", 1);
        $this->assertEquals($spaceCreated->getBuilding()->getId(), 2);
    }

    public function testCanBeDeleted()
    {
        $space = clone self::$exampleSpace;
        self::$spaceDAO->add($space);
        self::$spaceDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $spaceCreated = self::$spaceDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $spaceCreated = self::$spaceDAO->showAll();
        $this->assertEmpty($spaceCreated);
    }

    public function testCanShowSeveral()
    {
        $space1 = clone self::$exampleSpace;
        $space1->setId(2);
        $space2 = clone self::$exampleSpace;
        $space2->setId(3);
        $space2->setBuilding(self::$buildingDAO->show("id", 2));
        $space3 = clone self::$exampleSpace;
        $space3->setId(4);
        $space3->setBuilding(self::$buildingDAO->show("id", 3));


        self::$spaceDAO->add($space1);
        self::$spaceDAO->add($space2);
        self::$spaceDAO->add($space3);

        $universitiessCreated = self::$spaceDAO->showAll();

        $this->assertTrue($universitiessCreated[0]->getId() == 2);
        $this->assertTrue($universitiessCreated[1]->getId() == 3);
        $this->assertTrue($universitiessCreated[2]->getId() == 4);
    }
}
