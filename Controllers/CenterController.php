<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Center/CenterDAO.php';
include_once '../Models/University/UniversityDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Center/CenterShowAllView.php';
include_once '../Views/Center/CenterAddView.php';
include_once '../Views/Center/CenterShowView.php';
include_once '../Views/Center/CenterEditView.php';
include_once '../Views/Center/CenterSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/IsAdmin.php';
include_once '../Functions/IsUniversityOwner.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$centerDAO = new CenterDAO();
$universityDAO = new UniversityDAO();
$userDAO = new UserDAO();
$buildingDAO = new BuildingDAO();

//Data required
$universityData = $universityDAO->showAll();
$userData = $userDAO->showAll();
$buildingData = $buildingDAO->showAll();

$centerPrimaryKey = "id";
$value = $_REQUEST[$centerPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Center", "ADD")) {
            if (!isset($_POST["submit"])) {
                if(!IsAdmin()){
                    $universities=[];
                    foreach ($universityData as $university){
                        if($university->getUser()->getId() == $_SESSION['login']){
                            array_push($universities,$university);
                        }
                    }
                    $universityData=$universities;

                }
                new CenterAddView($universityData, $userData, $buildingData);
            } else {
                try {
                    $center = new Center();
                    $center->setUniversity($universityDAO->show("id", $_POST["university_id"]));
                    $center->setUser($userDAO->show("login", $_POST["user_id"]));
                    $center->setName($_POST["name"]);
                    $center->setBuilding($buildingDAO->show("id", $_POST["building_id"]));
                    $centerDAO->add($center);
                    goToShowAllAndShowSuccess("Centro añadido correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.");
        }
        break;
    case "delete":
        if (HavePermission("Center", "DELETE")) {
            $center = $centerDAO->show($centerPrimaryKey, $value);
            if(IsAdmin() || $center->getUniversity() == IsUniversityOwner()) {
                if (isset($_REQUEST["confirm"])) {
                    try {
                        $centerDAO->delete($centerPrimaryKey, $value);
                        goToShowAllAndShowSuccess("Centro eliminado correctamente.");
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage());
                    }
                } else {
                    try {
                        $centerDAO->checkDependencies($value);
                        showAll();
                        openDeletionModal("Eliminar centro", "¿Está seguro de que desea eliminar " .
                            "el centro %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                            "../Controllers/CenterController.php?action=delete&id=" . $value . "&confirm=true");
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage());
                    }
                }
            } else {
                goToShowAllAndShowError("No tienes permiso para eliminar.");
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Center", "SHOWCURRENT")) {
            try {
                $centerData = $centerDAO->show($centerPrimaryKey, $value);
                new CenterShowView($centerData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.");
        }
        break;
    case "edit":
        if (HavePermission("Center", "EDIT")) {
            try {
                $center = $centerDAO->show($centerPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    if(!IsAdmin()){
                        $universities=[];
                        foreach ($universityData as $university){
                            if($university->getUser()->getId() == $_SESSION['login']){
                                array_push($universities,$university);
                            }
                        }
                        $universityData=$universities;
                    }
                    if(IsAdmin() || $center->getUniversity() == IsUniversityOwner()){
                        new CenterEditView($center, $universityData, $userData, $buildingData);
                    } else{
                        goToShowAllAndShowError("No tienes permiso para editar.");
                    }

                } else {
                    $center->setId($value);
                    $center->setUniversity($universityDAO->show("id", $_POST["university_id"]));
                    $center->setUser($userDAO->show("login", $_POST["user_id"]));
                    $center->setName($_POST["name"]);
                    $center->setBuilding($buildingDAO->show("id", $_POST["building_id"]));
                    $universityDAO->edit($center);
                    goToShowAllAndShowSuccess("Centro editado correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    case "search":
        if (HavePermission("Center", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new CenterSearchView($universityData, $buildingData, $userData);
            } else {
                try {
                    $center = new Center();
                    if (!empty($_POST["university_id"])) {
                        $center->setUniversity($universityDAO->show("id", $_POST["university_id"]));
                    }
                    if (!empty($_POST["name"])) {
                        $center->setName($_POST["name"]);
                    }
                    if (!empty($_POST["building_id"])) {
                        $center->setBuilding($buildingDAO->show("id", $_POST["building_id"]));
                    }
                    showAllSearch($center);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.");
        }
        break;
    default:
        showAll();
        break;
}

function showAll()
{
    showAllSearch(NULL);
}

function showAllSearch($search)
{
    if (HavePermission("Center", "SHOWALL")) {
        try {
            $searching=False;
            if (!empty($search)) {
                $searching = True;
            }
            if (!IsAdmin()) {
                $userDAO = new UserDAO();
                $center = new Center();
                $university = IsUniversityOwner();
                if(!empty($university)){
                    $center->setUniversity($university);
                }else{
                    $center->setUser($userDAO->show("login", $_SESSION['login']));
                }
                $search = $center;
                $searching = False;
            }
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalCenters = $GLOBALS["centerDAO"]->countTotalCenters($toSearch);
            $centersData = $GLOBALS["centerDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new CenterShowAllView($centersData, $itemsPerPage, $currentPage, $totalCenters, $toSearch, $searching);
        } catch (DAOException $e) {
            new CenterShowAllView(array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message)
{
    showAll();
    errorMessage($message);
}

function goToShowAllAndShowSuccess($message)
{
    showAll();
    successMessage($message);
}