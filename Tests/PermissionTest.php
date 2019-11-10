<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

require_once '../Models/Permission/Permission.php';
require_once '../Models/FuncAction/Func_Action.php';
require_once '../Models/Permission/PermissionDAO.php';
require_once '../Models/FuncAction/FuncActionDAO.php';
require_once '../Models/Common/DAOException.php';

final class PermissionTest extends TestCase
{
    protected static $permissionDAO;
    protected static $funcActionDAO;
    protected static $examplePermission;
    protected static $exampleFuncAction;
    protected static $examplePermissionArray;
    protected static $exampleFuncActionArray;


    public static function setUpBeforeClass(): void
    {
        self::$permissionDAO = new PermissionDAO();
        self::$funcActionDAO = new FuncActionDAO();

        self::$funcActionDAO->add(new Func_Action(1, 2, 1));
        self::$funcActionDAO->add(new Func_Action(2, 2, 2));
        self::$funcActionDAO->add(new Func_Action(3, 2, 2));
        self::$funcActionDAO->add(new Func_Action(4, 2, 2));

        self::$examplePermission = new Permission(1, 3, 1);

        self::$examplePermissionArray = array(
            'submit' => true,
            'idPermission' => 1,
            'idRole' => 3,
            'idFuncAction' => 1,
        );
    }

    protected function tearDown(): void
    {
        try {
            self::$permissionDAO->delete('IdRole', 3);
        } catch (Exception $e) {
        }
    }

    public static function tearDownAfterClass(): void
    {
        try {
            self::$funcActionDAO->delete('IdFuncAction', 1);
            self::$funcActionDAO->delete('IdFuncAction', 2);
            self::$funcActionDAO->delete('IdFuncAction', 3);
            self::$funcActionDAO->delete('IdFuncAction', 4);
        } catch (Exception $e) {
        }
    }

    public
    function testCanBeCreated()
    {
        $permission = clone self::$examplePermission;
        $this->assertInstanceOf(
            Permission::class,
            $permission
        );
    }

    public
    function testCanBeAdded()
    {
        $permission = clone self::$examplePermission;
        self::$permissionDAO->add($permission);
        $permissionCreated = self::$permissionDAO->show('IdPermission', 1);
        $this->assertInstanceOf(Permission::class, $permissionCreated);
    }

    public
    function testCanBeUpdated()
    {
        $permission = clone self::$examplePermission;
        self::$permissionDAO->add($permission);
        $permission->setIdFuncAction(2);
        self::$permissionDAO->edit($permission);
        $permissionCreated = self::$permissionDAO->show('IdPermission', 1);
        $this->assertEquals($permissionCreated->getIdFuncAction(), 2);
    }

    public
    function testCanBeDeleted()
    {
        $permission = clone self::$examplePermission;
        self::$permissionDAO->add($permission);
        self::$permissionDAO->delete('IdPermission', 1);

        $this->expectException(DAOException::class);
        $permissionCreated = self::$permissionDAO->show('IdPermission', 1);
    }

    public
    function testCanShowNone()
    {
        $permissionCreated = self::$permissionDAO->showAll('IdPermission', 1);
        $this->assertEmpty($permissionCreated);
    }

    public
    function testCanShowSeveral()
    {
        $permission1 = clone self::$examplePermission;
        $permission1->setIdPermission(2);
        $permission2 = clone self::$examplePermission;
        $permission2->setIdPermission(3);
        $permission3 = clone self::$examplePermission;
        $permission3->setIdPermission(4);

        self::$permissionDAO->add($permission1);
        self::$permissionDAO->add($permission2);
        self::$permissionDAO->add($permission3);

        $permissionCreated = self::$permissionDAO->showAll('IdFuncAction', 1);

        $this->assertTrue($permissionCreated[0]->getIdPermission() == 2);
        $this->assertTrue($permissionCreated[1]->getIdPermission() == 3);
        $this->assertTrue($permissionCreated[2]->getIdPermission() == 4);

        self::$permissionDAO->delete('IdFuncAction', 1);
    }

    public
    function testIntCanBeCreated()
    {
        $postData = self::$examplePermissionArray;
        self::curlPost($postData, 'add', 1);
        $permissionCreated = self::$permissionDAO->show('IdRole', 3);
        $this->assertInstanceOf(Permission::class, $permissionCreated);
    }

    public
    function testIntCanBeUpdated()
    {
        $permission = clone self::$examplePermission;
        self::$permissionDAO->add($permission);
        $permissionCreated = self::$permissionDAO->show('IdRole', 3);

        $postData = self::$examplePermissionArray;
        $postData['idFuncAction'] = 2;
        self::curlPost($postData, "edit", $permissionCreated->getIdPermission());

        $permissionCreated = self::$permissionDAO->show('IdRole', 3);
        $this->assertEquals(2, $permissionCreated->getIdFuncAction());
    }

    public
    function testIntCanBeDeleted()
    {
        $permission = clone self::$examplePermission;
        self::$permissionDAO->add($permission);
        $permissionCreated = self::$permissionDAO->show('IdRole', 3);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch,
            CURLOPT_URL,
            "http://localhost/Controllers/PermissionController.php?action=delete&IdPermission=" . $permissionCreated->getIdPermission() . "&confirm=true"
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);

        $this->expectException(DAOException::class);
        $permissionCreated = self::$permissionDAO->show('IdRole', 3);
    }

    private
    function curlPost($postData, $action, $id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, "http://localhost/Controllers/PermissionController.php?action=" . $action . "&IdPermission=" . $id);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
    }
}
