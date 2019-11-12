<?php
include_once '../Models/Common/DefaultDAO.php';
include_once 'User.php';

class UserDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $usersDB = $this->defaultDAO->showAll("user");
        return $this->getUsersFromDB($usersDB);
    }

    function add($user) {
        $this->defaultDAO->insert($user, "login");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("user", $key, $value);
    }

    function show($key, $value) {
        $user_db = $this->defaultDAO->show("user", $key, $value);
        return new User($user_db["login"], $user_db["password"], $user_db["dni"], $user_db["name"],
            $user_db["surname"], $user_db["email"], $user_db["address"], $user_db["telephone"]);
    }

    function edit($user) {
        $this->defaultDAO->edit($user, "login");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("user");
    }

    function canBeLogged($login, $password) {
        echo $login;
        $result = $this->show("login", $login);
        if (!is_null($result)){
            if ($result->getPassword() != md5($password)){
                throw new DAOException('Contraseña incorrecta.');
            }
        } else {
            throw new DAOException("El usuario no existe.");
        }
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $usersDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new User(), $stringToSearch);
        return $this->getUsersFromDB($usersDB);
    }

    function countTotalUsers($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new User(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("user", $value);
    }

    private function getUsersFromDB($usersDB) {
        $users = array();
        foreach ($usersDB as $user) {
            array_push($users, new User($user["login"], $user["password"], $user["dni"], $user["name"],
                $user["surname"], $user["email"], $user["address"], $user["telephone"]));
        }
        return $users;
    }

}
