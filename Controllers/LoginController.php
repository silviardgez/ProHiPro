<?php
include '../Views/Common/Head.php';
include '../Views/LoginView.php';
include '../Functions/Login.php';

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'login-user') {
    loginUser();
}

