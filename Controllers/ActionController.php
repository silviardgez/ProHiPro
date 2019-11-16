<?php
session_start();
include_once '../Functions/Authentication.php';
if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/Action/ActionDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Action/ActionShowAllView.php';
include_once '../Views/Action/ActionAddView.php';
include_once '../Views/Action/ActionShowView.php';
include_once '../Views/Action/ActionEditView.php';
include_once '../Views/Action/ActionSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';
//DAO
$actionDAO = new ActionDAO();
$actionPrimaryKey = "id";
$value = $_REQUEST[$actionPrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Action", "ADD")) {
            if (!isset($_POST["submit"])) {
                new ActionAddView();
            } else {
                try {
                    $action = new Action();
                    $action->setName($_POST["name"]);
                    $action->setDescription($_POST["description"]);
                    $actionDAO->add($action);
                    goToShowAllAndShowSuccess("Acción añadida correctamente.");
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
        if (HavePermission("Action", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $actionDAO->delete($actionPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Acción eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $actionDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar acción", "¿Está seguro de que desea eliminar " .
                        "la acción %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/ActionController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Action", "SHOWCURRENT")) {
            try {
                $actionData = $actionDAO->show($actionPrimaryKey, $value);
                new ActionShowView($actionData);
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
        if (HavePermission("Action", "EDIT")) {
            try {
                $action = $actionDAO->show($actionPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new ActionEditView($action);
                } else {
                    $action->setId($value);
                    $action->setName($_POST["name"]);
                    $action->setDescription($_POST["description"]);
                    $actionDAO->edit($action);
                    goToShowAllAndShowSuccess("Acción editada correctamente.");
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
        if (HavePermission("Action", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new ActionSearchView();
            } else {
                try {
                    $action = new Action();
                    if(!empty($_POST["name"])) {
                        $action->setName($_POST["name"]);
                    }
                    if(!empty($_POST["description"])) {
                        $action->setDescription($_POST["description"]);
                    }
                    showAllSearch($action);
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
    if (HavePermission("Action", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalActions = $GLOBALS["actionDAO"]->countTotalActions($toSearch);
            $actionData = $GLOBALS["actionDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new ActionShowAllView($actionData, $itemsPerPage, $currentPage, $totalActions, $toSearch);
        } catch (DAOException $e) {
            new ActionShowAllView(array());
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