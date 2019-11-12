<?php
include_once '../Models/Common/MessageType.php';

function redirect($url)
{
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';
    echo $string;
}

function accessDenied()
{
    redirect("../Controllers/IndexController.php?accessDenied=true");
}

if (isset($_REQUEST["accessDenied"])) {
    $message = MessageType::ERROR;
    showToast($message, "No tienes permiso para acceder.");
}