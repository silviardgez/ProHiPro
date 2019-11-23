<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Space/SpaceShowAllView.php';
include_once '../Views/Space/SpaceAddView.php';
include_once '../Views/Space/SpaceShowView.php';
include_once '../Views/Space/SpaceEditView.php';
include_once '../Views/Space/SpaceSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$buildingDAO = new BuildingDAO();
$spaceDAO = new SpaceDAO();

//Data required
$buildingData = $buildingDAO->showAll();

$spacePrimaryKey = "id";
$value = $_REQUEST[$spacePrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Space", "ADD")) {
            if (!isset($_POST["submit"])) {
                new SpaceAddView($buildingData);
            } else {
                try {
                    $space = new Space();
                    $space->setName($_POST["name"]);
                    $space->setBuilding($buildingDAO->show("id",$_POST["building_id"]));
                    $space->setCapacity($_POST["capacity"]);
                    if (isset($_POST["office"])) {
                        $space->setOffice(1);
                    } else {
                        $space->setOffice(0);
                    }
                    $spaceDAO->add($space);
                    goToShowAllAndShowSuccess("Espacio añadido correctamente.");
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
        if (HavePermission("Space", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $spaceDAO->delete($spacePrimaryKey, $value);
                    goToShowAllAndShowSuccess("Espacio eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $spaceDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar espacio", "¿Está seguro de que desea eliminar " .
                        "el espacio %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/SpaceController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Space", "SHOWCURRENT")) {
            try {
                $spaceData = $spaceDAO->show($spacePrimaryKey, $value);
                new SpaceShowView($spaceData);
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
        if (HavePermission("Space", "EDIT")) {
            try {
                $space = $spaceDAO->show($spacePrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new SpaceEditView($space, $buildingData);
                } else {
                    $space->setId($value);
                    $space->setName($_POST["name"]);
                    $space->setBuilding($buildingDAO->show("id",$_POST["building_id"]));
                    $space->setCapacity($_POST["capacity"]);
                    $space->setOffice($_POST["office"]);
                    $spaceDAO->edit($space);
                    goToShowAllAndShowSuccess("Espacio editado correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else{
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    case "search":
        if (HavePermission("Space", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new SpaceSearchView($buildingData);
            } else {
                try {
                    $space = new Space();
                    if(!empty($_POST["name"])) {
                        $space->setName($_POST["name"]);
                    }
                    if(!empty($_POST["capacity"])) {
                        $space->setCapacity($_POST["capacity"]);
                    }
                    if(!empty($_POST["building_id"])) {
                        $space->setBuilding($buildingDAO->show("id", $_POST["building_id"]));
                    }
                    if(!empty($_POST["office"])) {
                        $space->setOffice($_POST["office"]);
                    }
                    showAllSearch($space);
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

function showAll() {
    showAllSearch(NULL);
}

function showAllSearch($search) {
    if (HavePermission("Space", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalSpaces = $GLOBALS["spaceDAO"]->countTotalSpaces($toSearch);
            $spacesData = $GLOBALS["spaceDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new SpaceShowAllView($spacesData, $itemsPerPage, $currentPage, $totalSpaces, $toSearch);
        } catch (DAOException $e) {
            new SpaceShowAllView(array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message) {
    showAll();
    errorMessage($message);
}

function goToShowAllAndShowSuccess($message) {
    showAll();
    successMessage($message);
}