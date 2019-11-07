<?php
include_once '../Models/Common/DefaultDAO.php';
include_once 'Role.php';

class RoleDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $roles_db = $this->defaultDAO->showAll("role");
        $roles = array();
        foreach ($roles_db as $role) {
            array_push($roles, new Role($role["IdRole"], $role["name"], $role["description"]));
        }
        return $roles;
    }

    function add($role) {
        return $this->defaultDAO->insert($role, "IdRole");
    }

    function delete($key, $value) {
        return $this->defaultDAO->delete("role", $key, $value);
    }

    function show($key, $value) {
        $role_db = $this->defaultDAO->show("role", $key, $value);
        return new Role($role_db["IdRole"], $role_db["name"], $role_db["description"]);
    }

    function edit($role) {
        return $this->defaultDAO->edit($role, "IdRole");
    }

    function truncateTable() {
        return $this->defaultDAO->truncateTable("role");
    }
}