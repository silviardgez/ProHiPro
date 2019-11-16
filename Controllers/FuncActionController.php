<?php
session_start();
include_once '../Functions/Authentication.php';
if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/FuncAction/FuncActionDAO.php';
include_once '../Models/Action/ActionDAO.php';
include_once '../Models/Functionality/FunctionalityDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Views/FuncAction/FuncActionShowAllView.php';
include_once '../Views/FuncAction/FuncActionAddView.php';
include_once '../Views/FuncAction/FuncActionShowView.php';
include_once '../Views/FuncAction/FuncActionEditView.php';
include_once '../Views/FuncAction/FuncActionSearchView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/Pagination.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Redirect.php';
//DAOS
$funcActionDAO = new FuncActionDAO();
$actionDAO = new ActionDAO();
$functionalityDAO = new FunctionalityDAO();
//Data required
$actionsData = $actionDAO->showAll();
$functionalitiesData = $functionalityDAO->showAll();
$funcActionPrimaryKey = "id";
$value = $_REQUEST[$funcActionPrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("FuncAction", "ADD")) {
            if (!isset($_POST["submit"])) {
                new FuncActionAddView($actionsData, $functionalitiesData);
            } else {
                try {
                    $funcAction = new FuncAction();
                    $funcAction->setAction($actionDAO->show("id", $_POST["action_id"]));
                    $funcAction->setFunctionality($functionalityDAO->show("id", $_POST["functionality_id"]));
                    $funcActionDAO->add($funcAction);
                    goToShowAllAndShowSuccess("Acción-funcionalidad añadida correctamente.");
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
        if (HavePermission("FuncAction", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $funcActionDAO->delete($funcActionPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Acción-funcionalidad eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $funcActionDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar acción-funcionalidad", "¿Está seguro de que desea eliminar " .
                        "la acción-funcionalidad %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/FuncActionController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("FuncAction", "SHOWCURRENT")) {
            try {
                $funcActionData = $funcActionDAO->show($funcActionPrimaryKey, $value);
                new FuncActionShowView($funcActionData);
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
        if (HavePermission("FuncAction", "EDIT")) {
            try {
                $funcAction = $funcActionDAO->show($funcActionPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new FuncActionEditView($funcAction, $actionsData, $functionalitiesData);
                } else {
                    $funcAction->setId($value);
                    $funcAction->setAction($actionDAO->show("id", $_POST["action_id"]));
                    $funcAction->setFunctionality($functionalityDAO->show("id", $_POST["functionality_id"]));
                    $funcActionDAO->edit($funcAction);
                    goToShowAllAndShowSuccess("Acción-funcionalidad editada correctamente.");
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
        if (HavePermission("FuncAction", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new FuncActionSearchView($actionsData, $functionalitiesData);
            } else {
                try {
                    $funcAction = new FuncAction();
                    if(!empty($_POST["action_id"])) {
                        $funcAction->setAction($actionDAO->show('id', $_POST["action_id"]));
                    }
                    if(!empty($_POST["functionality_id"])) {
                        $funcAction->setFunctionality($functionalityDAO->show('id', $_POST["functionality_id"]));
                    }
                    showAllSearch($funcAction);
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
function showAllSearch($search)
{
    if (HavePermission("FuncAction", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalFuncActions = $GLOBALS["funcActionDAO"]->countTotalFuncActions($toSearch);
            $funcActionsData = $GLOBALS["funcActionDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new FuncActionShowAllView($funcActionsData, $itemsPerPage, $currentPage, $totalFuncActions, $toSearch);
        } catch (DAOException $e) {
            new FuncActionShowAllView(array());
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