<?php
session_start();

include './Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:./Controllers/LoginController.php');
} else {
    header('Location:./Controllers/IndexController.php');
}
