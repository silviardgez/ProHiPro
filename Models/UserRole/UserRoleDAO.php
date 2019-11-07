<?php
include_once '../Models/Common/DefaultDAO.php';
include_once 'User_Role.php';

class UserRoleDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $userRole_db = $this->defaultDAO->showAll("user_role");
        $userRoles = array();
        foreach ($userRole_db as $userRole) {
            array_push($userRoles, new User_Role($userRole["IdUserRole"], $userRole["login"], $userRole["IdRole"]));
        }
        return $userRoles;
    }

    function add($userRole) {
        return $this->defaultDAO->insert($userRole,"IdUserRole");
    }

    function delete($key, $value) {
        return $this->defaultDAO->delete("user_role", $key, $value);
    }

    function show($key, $value) {
        $userRole = $this->defaultDAO->show("user_role", $key, $value);
        return new User_Role($userRole["IdUserRole"], $userRole["login"], $userRole["IdRole"]);
    }

    function edit($permission) {
        return $this->defaultDAO->edit($permission, "IdUserRole");
    }

    function truncateTable() {
        return $this->defaultDAO->truncateTable("user_role");
    }
}