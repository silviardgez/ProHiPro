<?php
include_once "../Models/Degree/DegreeDAO.php";

function IsDegreeOwner()
{
    $toret = array();
    $degreeDAO = new DegreeDAO();
    try {
        $degrees = $degreeDAO->showAll();
        foreach ($degrees as $degree) {
            if ($degree->getUser()->getId() == $_SESSION['login']) {
                array_push($toret, $degree);
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