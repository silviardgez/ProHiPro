<?php

session_start();
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}
include '../Models/User/UserDAO.php';
include '../Models/Common/MessageType.php';
include '../Models/Common/DAOException.php';
include '../Views/Common/Head.php';
include '../Views/Common/DefaultView.php';
include '../Views/User/UserShowAllView.php';
include '../Views/User/UserAddView.php';
include '../Views/User/UserShowView.php';
include '../Views/User/UserEditView.php';
include '../Functions/ShowToast.php';
include '../Functions/OpenDeletionModal.php';
include '../Functions/Redirect.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($action) {
    case "add":
        if (!isset($_POST["submit"])){
            new UserAddView();
        }
        else {
            try {
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
                $message = MessageType::SUCCESS;
                showAll();
                showToast($message, "Usuario añadido correctamente.");
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        }
        break;
    case "delete":
        if (isset($_REQUEST["confirm"])) {
            try {
                $key = "login";
                $value = $_REQUEST[$key];
                $userDAO = new UserDAO();
                $response = $userDAO->delete($key, $value);
                $message = MessageType::SUCCESS;
                showAll();
                showToast($message, "Usuario eliminado correctamente.");
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        } else {
            showAll();
            $key = "login";
            $value = $_REQUEST[$key];
            openDeletionModal("Eliminar usuario " . $value, "¿Está seguro de que desea eliminar " .
                "el usuario <b>" . $value . "</b>? Esta acción es permanente y no se puede recuperar.",
            "../Controllers/UserController.php?action=delete&login=" . $value . "&confirm=true");
        }
        break;
    case "show":
        try {
            $key = "login";
            $value = $_REQUEST[$key];
            $userDAO = new UserDAO();
            $userData = $userDAO->show($key, $value);
            new UserShowView($userData);
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            showAll();
            showToast($message, $e->getMessage());
        }
        break;
    case "edit":
        $key = "login";
        $value = $_REQUEST[$key];
        $userDAO = new UserDAO();
        try {
            $user = $userDAO->show($key, $value);
            if (!isset($_POST["submit"])){
                new UserEditView($user);
            } else {
                try {
                    $user->setPassword($_POST["password"]);
                    $user->setDni($_POST["dni"]);
                    $user->setName($_POST["name"]);
                    $user->setSurname($_POST["surname"]);
                    $user->setEmail($_POST["email"]);
                    $user->setAddress($_POST["address"]);
                    $user->setTelephone($_POST["telephone"]);

                    $userDAO = new UserDAO();
                    $response = $userDAO->edit($user);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Usuario editado correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                }
            }
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            showAll();
            showToast($message, $e->getMessage());
        }
        break;
    default:
        showAll();
        break;
}

function showAll() {
    try {
        $userDAO = new UserDAO();
        $usersData = $userDAO->showAll();
        new UserShowAllView($usersData);
    } catch (DAOException $e) {
        $message = MessageType::ERROR;
        new UserShowAllView(array());
        showToast($message, $e->getMessage());
    }
}
