<?php
include '../Models/User/UserDAO.php';
include '../Views/DefaultView.php';
include '../Views/User/UserShowAllView.php';
include '../Views/User/UserAddView.php';
include '../Views/User/UserShowView.php';
include '../Views/User/UserEditView.php';

switch($_REQUEST['action']) {
    case "add":
        if (!isset($_POST["submit"])){
            new UserAddView();
        }
        else {
            $user = new User();
            $user->setLogin($_POST["login"]);
            $user->setPassword($_POST["password"]);
            $user->setDni($_POST["dni"]);
            $user->setName($_POST["name"]);
            $user->setSurname($_POST["surname"]);
            $user->setEmail($_POST["email"]);
            $user->setAddress($_POST["address"]);
            $user->setTelephone($_POST["telephone"]);

            $userDAO = new UserDAO();
            $userDAO->add($user);
        }
        break;
    case "delete":
        $key = "login";
        $value = $_REQUEST[$key];
        $userDAO = new UserDAO();
        $userDAO->delete($key, $value);
        break;
    case "show":
        $key = "login";
        $value = $_REQUEST[$key];
        $userDAO = new UserDAO();
        $userData = $userDAO->show($key, $value);
        new UserShowView($userData);
        break;
    case "edit":
        $key = "login";
        $value = $_REQUEST[$key];
        $userDAO = new UserDAO();
        $user = $userDAO->show($key, $value);
        if (!isset($_POST["submit"])){
            new UserEditView($user);
        }
        else {
            $user->setLogin($_POST["login"]);
            $user->setPassword($_POST["password"]);
            $user->setDni($_POST["dni"]);
            $user->setName($_POST["name"]);
            $user->setSurname($_POST["surname"]);
            $user->setEmail($_POST["email"]);
            $user->setAddress($_POST["address"]);
            $user->setTelephone($_POST["telephone"]);

            $userDAO = new UserDAO();
            $userDAO->edit($user);
        }
        break;
    default:
        $userDAO = new UserDAO();
        $usersData = $userDAO->showAll();
        new UserShowAllView($usersData);
        break;
}
