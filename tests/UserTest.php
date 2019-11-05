<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/User/User.php';
include_once './UserTestDAO.php';

final class UserTest extends TestCase
{
    protected static $userDAO;

    public static function setUpBeforeClass(): void
    {
        self::$userDAO = new UserTestDAO();
    }

    public static function tearDownAfterClass(): void
    {
        self::$userDAO->truncateTable();
    }

    public function testCanBeCreated()
    {
        $user = new User('roi', 'roipass', '44661643J', 'roi', 'roiprez', 'roiprezl',
            'calle falsa 123', '666444666');
        $this->assertInstanceOf(
            User::class,
            $user
        );
    }

    public function testCanBeAdded()
    {
        $user = new User('roi', 'roipass', '44661643J', 'roi', 'roiprez', 'roiprezl',
            'calle falsa 123', '666444666');

        self::$userDAO->add($user);

        $userCreated = self::$userDAO->show("login", "roi");

        $this->assertInstanceOf(User::class, $userCreated);
    }

    public function testCanBeUpdated()
    {
        $user = new User('roi', 'roipass', '44661643J', 'roi', 'roiprez', 'roiprezl',
            'calle falsa 123', '666444666');

        self::$userDAO->add($user);

        $user->setAddress("Calle Falsa 124");

        self::$userDAO->edit($user);

        $userCreated = self::$userDAO->show("login", "roi");

        $this->assertEquals($userCreated->getAddress(), "Calle Falsa 124");
    }

    public function testCanBeDeleted()
    {
        $user = new User('roi', 'roipass', '44661643J', 'roi', 'roiprez', 'roiprezl',
            'calle falsa 123', '666444666');

        self::$userDAO->add($user);

        self::$userDAO->delete("login", "roi");

        $userCreated = self::$userDAO->show("login", "roi");

        $this->assertEmpty($userCreated);
    }

    public function testCanShowNone()
    {
        $userCreated = self::$userDAO->showAll("login", "roi");

        $this->assertEmpty($userCreated);
    }

    public function testCanShowSeveral()
    {
        $user1 = new User('roi', 'roipass', '44661643J', 'Roi', 'Perez', 'roiprezl',
            'calle falsa 123', '666444666');

        $user2 = new User('roi2', 'roipass', '44661643J', 'Roi', 'Perez', 'roiprezl',
            'calle falsa 123', '666444666');

        $user3 = new User('roi3', 'roipass', '44661643J', 'Roi', 'Perez', 'roiprezl',
            'calle falsa 123', '666444666');

        self::$userDAO->add($user1);
        self::$userDAO->add($user2);
        self::$userDAO->add($user3);

        $usersCreated = self::$userDAO->showAll("name", "Roi");

        $this->assertTrue($usersCreated[0]->getLogin() == 'roi');
        $this->assertTrue($usersCreated[1]->getLogin() == 'roi2');
        $this->assertTrue($usersCreated[2]->getLogin() == 'roi3');
    }
}
