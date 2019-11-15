<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Role/RoleDAO.php';
include_once 'UserRole.php';

class UserRoleDAO
{
    private $defaultDAO;
    private $userDAO;
    private $roleDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->userDAO = new UserDAO();
        $this->roleDAO = new RoleDAO();
    }

    function showAll() {
        $userRole_db = $this->defaultDAO->showAll("user_role");
        return $this->getUserRolesFromDB($userRole_db);
    }

    function add($userRole) {
        $this->defaultDAO->insert($userRole,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("user_role", $key, $value);
    }

    function show($key, $value) {
        $userRole = $this->defaultDAO->show("user_role", $key, $value);
        $user = $this->userDAO->show("login", $userRole["user_id"]);
        $role = $this->roleDAO->show("id", $userRole["role_id"]);
        return new UserRole($userRole["id"], $role, $user);
    }

    function edit($permission) {
        $this->defaultDAO->edit($permission, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("user_role");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $userRolesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new UserRole(), $stringToSearch);
        return $this->getUserRolesFromDB($userRolesDB);
    }

    function countTotalUserRoles($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new UserRole(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("user_role", $value);
    }

    private function getUserRolesFromDB($userRolesDB) {
        $userRoles = array();
        foreach ($userRolesDB as $userRole) {
            $user = $this->userDAO->show("login", $userRole["user_id"]);
            $role = $this->roleDAO->show("id", $userRole["role_id"]);
            array_push($userRoles, new UserRole($userRole["id"], $role, $user));
        }
        return $userRoles;
    }
}