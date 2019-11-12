<?php

session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/ShowToast.php';
if (!IsAuthenticated()){
 	header('Location:../index.php');
} else {
	include '../Views/Common/Head.php';
	include '../Views/Common/DefaultView.php';
	include '../Functions/Redirect.php';
}