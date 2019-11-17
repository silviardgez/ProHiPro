<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/User/User.php';
include_once '../Models/Building/Building.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class BuildingTest extends TestCase
{
    protected static $userDAO;
    protected static $buildingDAO;
    protected static $exampleBuilding;

    public static function setUpBeforeClass(): void
    {
        initTestDB();

        self::$buildingDAO = new BuildingDAO();
        self::$userDAO = new UserDAO();
        $user = new User('_test_', 'test_pass', '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        self::$userDAO->add($user);
        self::$exampleBuilding = new Building(1, 'Edificio Politécnico', 'Ourense', $user);
    }

    protected function tearDown(): void
    {
        try {
            self::$buildingDAO->delete('id', 1);
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
        $building = clone self::$exampleBuilding;
        $this->assertInstanceOf(
            Building::class,
            $building
        );
    }

    public function testCanBeAdded()
    {
        $building = clone self::$exampleBuilding;
        self::$buildingDAO->add($building);
        $buildingCreated = self::$buildingDAO->show("id", 1);
        $this->assertInstanceOf(Building::class, $buildingCreated);
    }

    public function testCanBeUpdated()
    {
        $building = clone self::$exampleBuilding;
        self::$buildingDAO->add($building);
        $building->setName('Edificio de Informática');
        self::$buildingDAO->edit($building);
        $buildingCreated = self::$buildingDAO->show("id", 1);
        $this->assertEquals($buildingCreated->getName(), 'Edificio de Informática');
    }

    public function testCanBeDeleted()
    {
        $building = clone self::$exampleBuilding;
        self::$buildingDAO->add($building);
        self::$buildingDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $buildingCreated = self::$buildingDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $buildingCreated = self::$buildingDAO->showAll();
        $this->assertEmpty($buildingCreated);
    }

    public function testCanShowSeveral()
    {
        $building1 = clone self::$exampleBuilding;
        $building1->setId(2);
        $building1->setName('Edificio de física');
        $building2 = clone self::$exampleBuilding;
        $building2->setId(3);
        $building2->setName('Edificio de derecho');
        $building3 = clone self::$exampleBuilding;
        $building3->setId(4);
        $building3->setName('Edificio de educación');


        self::$buildingDAO->add($building1);
        self::$buildingDAO->add($building2);
        self::$buildingDAO->add($building3);

        $buildingsCreated = self::$buildingDAO->showAll();

        $this->assertTrue(count($buildingsCreated) == 3);
    }
}
