<?php
function openDependenciesModal($title, $message) {
    include_once "../Views/Common/DependenciesModal.php";
    if(isset($title) && isset($message)) {
        echo '<script src="../JS/OpenDependenciesModal.js"></script>';
        echo '<script>';
        echo 'openDependenciesModal("' . $title . '","' . $message . '");';
        echo '</script>';
    }
}
