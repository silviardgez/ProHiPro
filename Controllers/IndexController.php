<?php

session_start();
include '../Functions/Authentication.php';
if (!IsAuthenticated()){
 	header('Location:../index.php');
} else {
	include '../Views/Common/Head.php';
	include '../Views/Common/DefaultView.php';
}