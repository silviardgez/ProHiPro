<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/User/User.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class UserTest extends TestCase
{
    protected static $userDAO;
    protected static $exampleUser;

    public static function setUpBeforeClass(): void
    {
        initTestDB();

        self::$userDAO = new UserDAO();
        self::$exampleUser = new User('_test_', 'test_pass', '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
    }

    protected function tearDown(): void
    {
        try {
            self::$userDAO->delete('login', '_test_');
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
        $user = clone self::$exampleUser;
        $this->assertInstanceOf(
            User::class,
            $user
        );
    }

    public function testCanBeAdded()
    {
        $user = clone self::$exampleUser;
        self::$userDAO->add($user);
        $userCreated = self::$userDAO->show("login", "_test_");
        $this->assertInstanceOf(User::class, $userCreated);
    }

    public function testCanBeUpdated()
    {
        $user = clone self::$exampleUser;
        self::$userDAO->add($user);
        $user->setAddress("Calle Falsa 124");
        self::$userDAO->edit($user);
        $userCreated = self::$userDAO->show("login", "_test_");
        $this->assertEquals($userCreated->getAddress(), "Calle Falsa 124");
    }

    public function testCanBeDeleted()
    {
        $user = clone self::$exampleUser;
        self::$userDAO->add($user);
        self::$userDAO->delete("login", "_test_");

        $this->expectException(DAOException::class);
        $userCreated = self::$userDAO->show("login", "_test_");
    }

    public function testCanShowNone()
    {
        $userCreated = self::$userDAO->showAll("login", "_test_");
        $this->assertEmpty($userCreated);
    }

    public function testCanShowSeveral()
    {
        $user1 = clone self::$exampleUser;
        $user1->setLogin('_test_1');
        $user2 = clone self::$exampleUser;
        $user2->setLogin('_test_2');
        $user3 = clone self::$exampleUser;
        $user3->setLogin('_test_3');

        self::$userDAO->add($user1);
        self::$userDAO->add($user2);
        self::$userDAO->add($user3);

        $usersCreated = self::$userDAO->showAll("name", "test");

        $this->assertTrue(count($usersCreated) == 3);
    }
}
