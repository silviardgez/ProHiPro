<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Common/DAOException.php';
include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Building/BuildingShowAllView.php';
include_once '../Views/Building/BuildingAddView.php';
include_once '../Views/Building/BuildingShowView.php';
include_once '../Views/Building/BuildingEditView.php';
include_once '../Views/Building/BuildingSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$buildingDAO = new BuildingDAO();
$userDAO = new UserDAO();

//Data required
$userData = $userDAO->showAll();

$buildingPrimaryKey = "id";
$value = $_REQUEST[$buildingPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Building", "ADD")) {
            if (!isset($_POST["submit"])) {
                new BuildingAddView($userData);
            } else {
                try {
                    $building = new Building();
                    $building->setUser($userDAO->show("login", $_POST["user_id"]));
                    $building->setName($_POST["name"]);
                    $building->setLocation($_POST["location"]);
                    $buildingDAO->add($building);
                    goToShowAllAndShowSuccess("Edificio añadido correctamente.");
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
        if (HavePermission("Building", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $buildingDAO->delete($buildingPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Edificio eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $buildingDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar Edificio", "¿Está seguro de que desea eliminar " .
                        "el edificio %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/BuildingController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Building", "SHOWCURRENT")) {
            try {
                $buildingData = $buildingDAO->show($buildingPrimaryKey, $value);
                new BuildingShowView($buildingData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso visualizar la entidad.");
        }
        break;
    case "edit":
        if (HavePermission("Building", "EDIT")) {
            try {
                $building = $buildingDAO->show($buildingPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new BuildingEditView($building, $userData);
                } else {
                    $building->setId($value);
                    $building->setName($_POST["name"]);
                    $building->setLocation($_POST["location"]);
                    $building->setUser($userDAO->show("login", $_POST["user_id"]));
                    $buildingDAO->edit($building);
                    goToShowAllAndShowSuccess("Edificio editado correctamente.");
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
        if (HavePermission("Building", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new BuildingSearchView();
            } else {
                try {
                    $building = new Building();
                    if (!empty($_POST["name"])) {
                        $building->setName($_POST["name"]);
                    }
                    if (!empty($_POST["location"])) {
                        $building->setLocation($_POST["location"]);
                    }
                    showAllSearch($building);
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
    if (HavePermission("Building", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalBuildings = $GLOBALS["buildingDAO"]->countTotalBuildings($toSearch);
            $buildingsData = $GLOBALS["buildingDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new BuildingShowAllView($buildingsData, $itemsPerPage, $currentPage, $totalBuildings, $toSearch);
        } catch (DAOException $e) {
            new BuildingShowAllView(array());
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