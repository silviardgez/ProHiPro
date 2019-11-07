<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/User/User.php';
include_once '../Models/User/UserDAO.php';

final class UserTest extends TestCase
{
    protected static $userDAO;
    protected static $userTestDAO;

    public static function setUpBeforeClass(): void
    {
        $_SESSION['env'] = 'dev';
        self::$userDAO = new UserDAO();

        $_SESSION['env'] = 'test';
        self::$userTestDAO = new UserDAO();
    }

    public static function tearDownAfterClass(): void
    {
        self::$userTestDAO->truncateTable();
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

        self::$userTestDAO->add($user);

        $userCreated = self::$userTestDAO->show("login", "roi");

        $this->assertInstanceOf(User::class, $userCreated);
    }

    public function testCanBeUpdated()
    {
        $user = new User('roi', 'roipass', '44661643J', 'roi', 'roiprez', 'roiprezl',
            'calle falsa 123', '666444666');

        self::$userTestDAO->add($user);

        $user->setAddress("Calle Falsa 124");

        self::$userTestDAO->edit($user);

        $userCreated = self::$userTestDAO->show("login", "roi");

        $this->assertEquals($userCreated->getAddress(), "Calle Falsa 124");
    }

    public function testCanBeDeleted()
    {
        $user = new User('roi', 'roipass', '44661643J', 'roi', 'roiprez', 'roiprezl',
            'calle falsa 123', '666444666');

        self::$userTestDAO->add($user);

        self::$userTestDAO->delete("login", "roi");

        $userCreated = self::$userTestDAO->show("login", "roi");

        $this->assertEmpty($userCreated);
    }

    public function testCanShowNone()
    {
        $userCreated = self::$userTestDAO->showAll("login", "roi");

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

        self::$userTestDAO->add($user1);
        self::$userTestDAO->add($user2);
        self::$userTestDAO->add($user3);

        $usersCreated = self::$userTestDAO->showAll("name", "Roi");

        $this->assertTrue($usersCreated[0]->getLogin() == 'roi');
        $this->assertTrue($usersCreated[1]->getLogin() == 'roi2');
        $this->assertTrue($usersCreated[2]->getLogin() == 'roi3');
    }

    public function testIntCanBeCreated()
    {
        $postData = array(
            'submit' => true,
            'login' => 'roi',
            'password' => 'roi',
            'dni' => 'roi',
            'name' => 'roi',
            'surname' => 'roi',
            'email' => 'roi',
            'address' => 'roi',
            'telephone' => 'roi',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, "http://localhost/Controllers/UserController.php?action=add");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($ch);
        curl_close($ch);

        $userCreated = self::$userDAO->show("login", "roi");

        $this->assertInstanceOf(User::class, $userCreated);

        self::$userDAO->delete('login', 'roi');
    }

    public function testIntCanBeUpdated()
    {
        $user = new User('roi', 'roipass', '44661643J', 'roi', 'roiprez', 'roiprezl',
            'calle falsa 123', '666444666');

        self::$userDAO->add($user);

        $postData = array(
            'submit' => true,
            'login' => 'roi',
            'password' => 'roi',
            'dni' => 'roi',
            'name' => 'roi',
            'surname' => 'roi',
            'email' => 'roi',
            'address' => 'roi',
            'telephone' => 'roi',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, "http://localhost/Controllers/UserController.php?action=edit&login=roi");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($ch);
        curl_close($ch);

        $userCreated = self::$userDAO->show("login", "roi");

        $this->assertEquals('roi', $userCreated->getAddress());

        self::$userDAO->delete('login', 'roi');
    }

    public function testIntCanBeDeleted()
    {
        $user = new User('roi', 'roipass', '44661643J', 'roi', 'roiprez', 'roiprezl',
            'calle falsa 123', '666444666');

        self::$userDAO->add($user);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, "http://localhost/Controllers/UserController.php?action=delete&login=roi");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($ch);
        curl_close($ch);

        $userCreated = self::$userDAO->show("login", "roi");

        $this->assertEmpty($userCreated);
    }
}
