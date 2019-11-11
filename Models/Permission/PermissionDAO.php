<?php
include_once '../Models/Common/DefaultDAO.php';
include_once 'Permission.php';

class PermissionDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $permission_db = $this->defaultDAO->showAll("permission");
        return $this->getPermissionFromDB($permission_db);
    }

    function add($permission) {
        return $this->defaultDAO->insert($permission,"IdPermission");
    }

    function delete($key, $value) {
        return $this->defaultDAO->delete("permission", $key, $value);
    }

    function show($key, $value) {
        $permission_db = $this->defaultDAO->show("permission", $key, $value);
        return new Permission($permission_db["IdPermission"], $permission_db["IdRole"], $permission_db["IdFuncAction"]);
    }

    function edit($permission) {
        return $this->defaultDAO->edit($permission, "IdPermission");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $permissionDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Permission(), $stringToSearch);
        return $this->getPermissionFromDB($permissionDB);
    }

    function countTotalPermissions($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new Permission(), $stringToSearch);
    }

    private function getPermissionFromDB($permissions_db) {
        $permissions = array();
        foreach ($permissions_db as $permission) {
            array_push($permissions, new Permission($permission["IdPermission"], $permission["IdRole"], $permission["IdFuncAction"]));
        }
        return $permissions;
    }

    function truncateTable() {
        return $this->defaultDAO->truncateTable("permission");
    }
}