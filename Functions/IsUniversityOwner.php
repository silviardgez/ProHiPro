<?php
include_once  "../Models/University/UniversityDAO.php";
include_once "../Models/University/University.php";
function IsUniversityOwner()
{
    $toret = array();
    $universityDAO = new UniversityDAO();
    try{
        $universities = $universityDAO->showAll();
        foreach ($universities as $university){
            if($university->getUser()->getId() == $_SESSION['login']){
                array_push($toret, $university);
            }
        }
        if (empty($toret)) {
            return false;
        } else {
            return $toret;
        }
    }
    catch (DAOException $e){
        return false;
    }
}