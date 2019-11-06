<?php
function openDeletionModal($title, $message, $href) {
    include_once "../Views/Common/ConfirmDeletionModal.php";
    if(isset($title) && isset($message)) {
        echo '<script src="../JS/OpenDeletionModal.js"></script>';
        echo '<script>';
        echo 'openDeletionModal("' . $title . '","' . $message . '","' . $href . '");';
        echo '</script>';
    }
}
