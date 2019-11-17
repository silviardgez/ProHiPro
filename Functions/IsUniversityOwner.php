<?php
include_once  "../Models/University/UniversityDAO.php";
function IsUniversityOwner()
{
    $universityDAO = new UniversityDAO();
    try{
        $universities = $universityDAO->showAll();
        foreach ($universities as $university){
            if($university->getUser()->getId() == $_SESSION['login']){
                return $university;
            }
        }
        return false;
    }
    catch (DAOException $e){
        return false;
    }
}