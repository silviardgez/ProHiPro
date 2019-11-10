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
        $permissions = array();
        foreach ($permission_db as $permission) {
            array_push($permissions, new Permission($permission["IdPermission"], $permission["IdRole"], $permission["IdFuncAction"]));
        }
        return $permissions;
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

    function truncateTable() {
        return $this->defaultDAO->truncateTable("permission");
    }
}