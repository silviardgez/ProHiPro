<?php
include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';

function loginUser($login, $password)
{
    $userDAO = new UserDAO();

    try {
        $userDAO->canBeLogged($login, $password);
        session_start();
        $_SESSION['login'] = $login;
        header('Location:../index.php');
    } catch (DAOException $e) {
        include '../Models/Common/MessageType.php';
        include '../Functions/ShowToast.php';
        $message = MessageType::ERROR;
        showToast($message, $e->getMessage());
    }
}


