<?php
include_once "../Models/Building/BuildingDAO.php";

function IsBuildingOwner()
{
    $toret = array();
    $buildingDAO = new BuildingDAO();
    try {
        $buildings = $buildingDAO->showAll();
        foreach ($buildings as $building) {
            if ($building->getUser()->getId() == $_SESSION['login']) {
                array_push($toret, $building);
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