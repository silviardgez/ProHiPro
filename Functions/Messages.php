<?php
include_once '../Models/Common/MessageType.php';
include_once '../Functions/ShowToast.php';

function errorMessage($message) {
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function successMessage($message) {
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}