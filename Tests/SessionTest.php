<?php
declare (strict_types=1);
use PHPUnit\Framework\TestCase;
include_once '../Models/User/User.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Functions/Login.php';
final class SessionTest extends TestCase
{
    protected static $userDAO;
    protected static $exampleUser;
    public static function setUpBeforeClass(): void
    {
        self::$userDAO = new UserDAO();
        self::$exampleUser = new User('_test_', md5('test_pass'), '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        self::$userDAO->add(self::$exampleUser);
    }
    protected function tearDown(): void
    {
        try {
            self::$userDAO->delete('login', '_test_');
        } catch (Exception $e) {}
    }
    public function testCanLogIn()
    {
        loginUser("_test_", 'test_pass');
        $this->assertEquals($_SESSION['login'], "_test_");
    }
}