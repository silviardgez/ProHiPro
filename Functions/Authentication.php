<?php
function IsAuthenticated()
{
    if (!isset($_SESSION['login'])) {
        return false;
    } else {
        return true;
    }
}