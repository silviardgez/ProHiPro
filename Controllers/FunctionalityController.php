<?php
session_start();
include_once '../Functions/Authentication.php';
if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/Functionality/FunctionalityDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Functionality/FunctionalityShowAllView.php';
include_once '../Views/Functionality/FunctionalityAddView.php';
include_once '../Views/Functionality/FunctionalityShowView.php';
include_once '../Views/Functionality/FunctionalityEditView.php';
include_once '../Views/Functionality/FunctionalitySearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';
//DAO
$functionalityDAO = new FunctionalityDAO();
$functionalityPrimaryKey = "id";
$value = $_REQUEST[$functionalityPrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Functionality", "ADD")) {
            if (!isset($_POST["submit"])) {
                new FunctionalityAddView();
            } else {
                try {
                    $functionality = new Functionality();
                    $functionality->setName($_POST["name"]);
                    $functionality->setDescription($_POST["description"]);
                    $functionalityDAO->add($functionality);
                    goToShowAllAndShowSuccess("Funcionalidad añadida correctamente.");
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
        if (HavePermission("Functionality", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $functionalityDAO->delete($functionalityPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Funcionalidad eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $functionalityDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar funcionalidad", "¿Está seguro de que desea eliminar " .
                        "la funcionalidad %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/FunctionalityController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Functionality", "SHOWCURRENT")) {
            try {
                $functionalityData = $functionalityDAO->show($functionalityPrimaryKey, $value);
                new FunctionalityShowView($functionalityData);
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
        if (HavePermission("Functionality", "EDIT")) {
            try {
                $functionality = $functionalityDAO->show($functionalityPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new FunctionalityEditView($functionality);
                } else {
                    $functionality->setId($value);
                    $functionality->setName($_POST["name"]);
                    $functionality->setDescription($_POST["description"]);
                    $functionalityDAO->edit($functionality);
                    goToShowAllAndShowSuccess("Funcionalidad editada correctamente.");
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
        if (HavePermission("Functionality", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new FunctionalitySearchView();
            } else {
                try {
                    $functionality = new Functionality();
                    if(!empty($_POST["name"])) {
                        $functionality->setName($_POST["name"]);
                    }
                    if(!empty($_POST["description"])) {
                        $functionality->setDescription($_POST["description"]);
                    }
                    showAllSearch($functionality);
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
    if (HavePermission("Functionality", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalFunctionalities = $GLOBALS["functionalityDAO"]->countTotalFunctionalities($toSearch);
            $functionalityData = $GLOBALS["functionalityDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new FunctionalityShowAllView($functionalityData, $itemsPerPage, $currentPage, $totalFunctionalities, $toSearch);
        } catch (DAOException $e) {
            new FunctionalityShowAllView(array());
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