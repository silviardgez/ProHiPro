<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/User/User.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';

final class UserTest extends TestCase
{
    protected static $userDAO;
    protected static $exampleUser;
    protected static $exampleUserArray;

    public static function setUpBeforeClass(): void
    {
        shell_exec('mysqldump --opt --no-create-info  -u userTEC -ppassTEC TEC > ../dump.sql');
        shell_exec('mysql -u userTEC -ppassTEC < ../build_database.sql');

        self::$userDAO = new UserDAO();
        self::$exampleUser = new User('_test_', 'test_pass', '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        self::$exampleUserArray = array(
            'submit' => true,
            'login' => '_test_',
            'password' => 'test_pass',
            'dni' => '11111111A',
            'name' => 'test',
            'surname' => 'test user',
            'email' => 'test@example.com',
            'address' => 'calle falsa 123',
            'telephone' => '666444666',
        );
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
            shell_exec('mysql -u userTEC -ppassTEC < ../build_database.sql');
            shell_exec('mysql -u userTEC -ppassTEC TEC < ../dump.sql');
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

        $this->assertTrue($usersCreated[0]->getLogin() == '_test_1');
        $this->assertTrue($usersCreated[1]->getLogin() == '_test_2');
        $this->assertTrue($usersCreated[2]->getLogin() == '_test_3');

        self::$userDAO->delete('name', 'test');
    }

    public function testIntCanBeCreated()
    {
        $postData = self::$exampleUserArray;
        self::curlPost($postData, 'add');
        $userCreated = self::$userDAO->show("login", "_test_");
        $this->assertInstanceOf(User::class, $userCreated);
    }

    public function testIntCanBeUpdated()
    {
        $user = clone self::$exampleUser;
        self::$userDAO->add($user);
        $postData = self::$exampleUserArray;
        $postData['address'] = 'calle falsa 124';
        self::curlPost($postData, "edit");
        $userCreated = self::$userDAO->show("login", "_test_");
        $this->assertEquals('calle falsa 124', $userCreated->getAddress());
    }

    public function testIntCanBeDeleted()
    {
        $user = clone self::$exampleUser;
        self::$userDAO->add($user);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch,
            CURLOPT_URL,
            "http://localhost/Controllers/UserController.php?action=delete&login=_test_&confirm=true"
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);

        $this->expectException(DAOException::class);
        $userCreated = self::$userDAO->show("login", "_test_");
    }

    private function curlPost($postData, $action)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, "http://localhost/Controllers/UserController.php?action=" . $action);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }
}
