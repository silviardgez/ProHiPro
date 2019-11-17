<?php
include_once  "../Models/Building/BuildingDAO.php";

function IsBuildingOwner()
{
    $buildingDAO = new BuildingDAO();
    try{
        $buildings = $buildingDAO->showAll();
        foreach ($buildings as $building){
            if($building->getUser()->getId() == $_SESSION['login']){
                return $building;
            }
        }
        return false;
    }
    catch (DAOException $e){
        return false;
    }
}