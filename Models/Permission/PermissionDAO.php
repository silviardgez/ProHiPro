<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Role/RoleDAO.php';
include_once '../Models/FuncAction/FuncActionDAO.php';
include_once 'Permission.php';

class PermissionDAO
{
    private $defaultDAO;
    private $roleDAO;
    private $funcActionDAO;


    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->roleDAO = new RoleDAO();
        $this->funcActionDAO = new FuncActionDAO();
    }

    function showAll() {
        $permission_db = $this->defaultDAO->showAll("permission");
        return $this->getPermissionsFromDB($permission_db);
    }

    function add($permission) {
        $this->defaultDAO->insert($permission,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("permission", $key, $value);
    }

    function show($key, $value) {
        $permission_db = $this->defaultDAO->show("permission", $key, $value);
        $role = $this->roleDAO->show("id", $permission_db["role_id"]);
        $funcAction = $this->funcActionDAO->show("id", $permission_db["func_action_id"]);
        return new Permission($permission_db["id"], $role, $funcAction);
    }

    function edit($permission) {
        $this->defaultDAO->edit($permission, "id");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $permissionsDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Permission(), $stringToSearch);
        return $this->getPermissionsFromDB($permissionsDB);
    }

    function countTotalPermissions($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new Permission(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("permission", $value);
    }

    private function getPermissionsFromDB($permissions_db) {
        $permissions = array();
        foreach ($permissions_db as $permission) {
            $role = $this->roleDAO->show("id", $permission["role_id"]);
            $funcAction = $this->funcActionDAO->show("id", $permission["func_action_id"]);
            array_push($permissions, new Permission($permission["id"], $role, $funcAction));
        }
        return $permissions;
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("permission");
    }
}