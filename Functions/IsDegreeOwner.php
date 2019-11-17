<?php
include_once  "../Models/Degree/Degree.php";

function IsDegreeOwner()
{
    $degreeDAO = new DegreeDAO();
    try{
        $degrees = $degreeDAO->showAll();
        foreach ($degrees as $degree){
            if($degree->getUser()->getId() == $_SESSION['login']){
                return $degree;
            }
        }
        return false;
    }
    catch (DAOException $e){
        return false;
    }
}