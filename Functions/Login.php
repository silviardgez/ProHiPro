<?php
include '../Models/User/UserDAO.php';
include '../Models/Common/DAOException.php';

function loginUser()
{
    $userDAO = new UserDAO();
    $login = $_REQUEST['login'];
    $password = $_REQUEST['password'];
    try {
        $userDAO->canBeLogged($login, $password);
        session_start();
        $_SESSION['login'] = $login;
        header('Location:../index.php');
    } catch (DAOException $e) {
        include '../Models/Common/MessageType.php';
        include '../Functions/ShowToast.php';
        $message = MessageType::ERROR;
        showToast($message, $e);
    }
}


