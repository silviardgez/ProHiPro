<?php
include_once '../Models/DefaultDAO.php';
include_once 'User.php';

class UserDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    public function testConstruct() {
        $this->defaultDAO = DefaultDAO::testConstruct();
        return $this->defaultDAO;
    }

    function showAll() {
        $users_db = $this->defaultDAO->showAll("user");
        $users = array();
        if (is_string($users_db)) {
            return $users_db;
        } else {
            foreach ($users_db as $user) {
                array_push($users, new User($user["login"], $user["password"], $user["dni"], $user["name"],
                    $user["surname"], $user["email"], $user["address"], $user["telephone"]));
            }
            return $users;
        }
    }

    function add($user) {
        return $this->defaultDAO->insert($user, "login");
    }

    function delete($key, $value) {
        return $this->defaultDAO->delete("user", $key, $value);
    }

    function show($key, $value) {
        $user_db = $this->defaultDAO->show("user", $key, $value);
        if(!empty($user_db)) {
            return new User($user_db["login"], $user_db["password"], $user_db["dni"], $user_db["name"],
                $user_db["surname"], $user_db["email"], $user_db["address"], $user_db["telephone"]);
        } else {
            return null;
        }
    }

    function edit($user) {
        return $this->defaultDAO->edit($user, "login");
    }

}