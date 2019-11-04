<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/User/User.php';
include_once '../Models/User/UserDAO.php';

final class UserTest extends TestCase
{
    public function testUserCanBeCreated()
    {
        $user = new User('roi', 'roipass', '44661643J', 'roi', 'roiprez', 'roiprezl',
            'calle falsa 123', '666444666');
        $this->assertInstanceOf(
            User::class,
            $user
        );
    }

    public function testUserCanBeAdded()
    {
        $user = new User('roi', 'roipass', '44661643J', 'roi', 'roiprez', 'roiprezl',
            'calle falsa 123', '666444666');


        $userDAO = new UserDAO();

        $userDAO->add($user);

        $userCreated = $userDAO->show("login", "roi");

        $this->assertInstanceOf(User::class, $userCreated);

        $userDAO->delete("login", "roi");
    }
}
