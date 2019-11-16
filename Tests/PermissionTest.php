<?php
declare (strict_types=1);
use PHPUnit\Framework\TestCase;
include_once '../Models/Permission/Permission.php';
include_once '../Models/FuncAction/FuncAction.php';
include_once '../Models/Action/Action.php';
include_once '../Models/Functionality/Functionality.php';
include_once '../Models/Role/Role.php';
include_once '../Models/Permission/PermissionDAO.php';
include_once '../Models/FuncAction/FuncActionDAO.php';
include_once '../Models/Action/ActionDAO.php';
include_once '../Models/Functionality/FunctionalityDAO.php';
include_once '../Models/Role/RoleDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';
final class PermissionTest extends TestCase
{
    protected static $permissionDAO;
    protected static $funcActionDAO;
    protected static $actionDAO;
    protected static $functionalityDAO;
    protected static $roleDAO;
    protected static $examplePermission;
    protected static $exampleFuncAction;
    public static function setUpBeforeClass(): void
    {
        shell_exec('mysqldump --opt --no-create-info  -u userTEC -ppassTEC TEC > ../dump.sql');
        shell_exec('mysql -u userTEC -ppassTEC < ../build_database.sql');

        self::$permissionDAO = new PermissionDAO();
        self::$funcActionDAO = new FuncActionDAO();
        self::$actionDAO = new ActionDAO();
        self::$functionalityDAO = new FunctionalityDAO();
        self::$roleDAO = new RoleDAO();
        $action1 = new Action(2, 'Test1', 'ADD');
        $action2 = new Action(3, 'Test2', 'SHOW');
        $action3 = new Action(4, 'Test3', 'SHOWALL');
        self::$actionDAO->add($action1);
        self::$actionDAO->add($action2);
        self::$actionDAO->add($action3);
        $functionality1 = new Functionality(1, 'Test1', 'UsersManagement');
        $functionality2 = new Functionality(2, 'Test2', 'RolesManagement');
        self::$functionalityDAO->add($functionality1);
        self::$functionalityDAO->add($functionality2);
        $role = new Role(3, 'Test', 'Role to test');
        self::$roleDAO->add($role);
        $func_action = new FuncAction(1, $action1, $functionality1);
        self::$funcActionDAO->add($func_action);
        self::$funcActionDAO->add(new FuncAction(2, $action1, $functionality2));
        self::$funcActionDAO->add(new FuncAction(3, $action2, $functionality2));
        self::$funcActionDAO->add(new FuncAction(4, $action3, $functionality2));
        self::$examplePermission = new Permission(1, $role, $func_action);
    }
    protected function tearDown(): void
    {
        try {
            self::$permissionDAO->delete('id', 1);
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
        $permissionCreated = self::$permissionDAO->show('id', 1);
        $this->assertInstanceOf(Permission::class, $permissionCreated);
    }
    public
    function testCanBeUpdated()
    {
        $permission = clone self::$examplePermission;
        self::$permissionDAO->add($permission);
        $funcAction = self::$funcActionDAO->show('id', 1);
        $funcAction->setId(2);
        $permission->setFuncAction($funcAction);
        self::$permissionDAO->edit($permission);
        $permissionCreated = self::$permissionDAO->show('id', 1);
        $this->assertEquals($permissionCreated->getFuncAction()->getId(), 2);
    }
    public
    function testCanBeDeleted()
    {
        $permission = clone self::$examplePermission;
        self::$permissionDAO->add($permission);
        self::$permissionDAO->delete('id', 1);
        $this->expectException(DAOException::class);
        $permissionCreated = self::$permissionDAO->show('id', 1);
    }
    public
    function testCanShowNone()
    {
        $permissionCreated = self::$permissionDAO->showAll('id', 1);
        $this->assertEmpty($permissionCreated);
    }
    public
    function testCanShowSeveral()
    {
        $permission1 = clone self::$examplePermission;
        $permission1->setId(1);
        $permission2 = clone self::$examplePermission;
        $permission2->setId(2);
        $permission2->setFuncAction(self::$funcActionDAO->show('id', 2));
        $permission3 = clone self::$examplePermission;
        $permission3->setId(3);
        $permission3->setFuncAction(self::$funcActionDAO->show('id', 3));
        self::$permissionDAO->add($permission1);
        self::$permissionDAO->add($permission2);
        self::$permissionDAO->add($permission3);
        $permissionCreated = self::$permissionDAO->showAll();
        $this->assertTrue($permissionCreated[0]->getId() == 1);
        $this->assertTrue($permissionCreated[1]->getId() == 2);
        $this->assertTrue($permissionCreated[2]->getId() == 3);
    }
}