<?php
include_once  "../Models/Center/CenterDAO.php";

function IsCenterOwner()
{
    $centerDAO = new CenterDAO();
    try{
        $centers = $centerDAO->showAll();
        foreach ($centers as $center){
            if($center->getUser()->getId() == $_SESSION['login']){
                return $center;
            }
        }
        return false;
    }
    catch (DAOException $e){
        return false;
    }
}