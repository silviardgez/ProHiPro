<?php
include_once "../Models/Center/CenterDAO.php";

function IsCenterOwner()
{
    $toret = array();
    $centerDAO = new CenterDAO();
    try {
        $centers = $centerDAO->showAll();
        foreach ($centers as $center) {
            if ($center->getUser()->getId() == $_SESSION['login']) {
                array_push($toret, $center);
            }
        }
        if (empty($toret)) {
            return false;
        } else {
            return $toret;
        }
    } catch (DAOException $e) {
        return false;
    }
}