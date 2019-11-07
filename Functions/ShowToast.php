<?php
function showToast($messageType, $message) {
    include_once '../Views/Common/MessageToast.php';
    if(isset($messageType) && isset($message)) {
        echo '<script src="../JS/ToastTrigger.js"></script>';
        echo '<script>';
        echo 'showToast("' . $messageType[0] . '", "' . $messageType[1] . '", "' . $message . '");';
        echo '</script>';
    }
}
