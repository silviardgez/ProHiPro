<?php
session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/HavePermission.php';
if (!IsAuthenticated()){
    header('Location:../index.php');
}
include_once '../Models/FuncAction/FuncActionDAO.php';
include_once '../Models/Permission/PermissionDAO.php';
include_once '../Models/Role/RoleDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Permission/PermissionShowAllView.php';
include_once '../Views/Permission/PermissionAddView.php';
include_once '../Views/Permission/PermissionShowView.php';
include_once '../Views/Permission/PermissionEditView.php';
include_once '../Views/Permission/PermissionSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

// DAOS
$funcActionDAO = new FuncActionDAO();
$permissionDAO = new PermissionDAO();
$roleDAO = new RoleDAO();

// Data required
$funcActionsData = $funcActionDAO->showAll();
$rolesData = $roleDAO->showAll();

$permissionPrimaryKey = "id";
$value = $_REQUEST[$permissionPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($action) {
    case "add":
        if (HavePermission("Permission", "ADD")) {
            if (!isset($_POST["submit"])) {
                new PermissionAddView($rolesData, $funcActionsData);
            } else {
                try {
                    $permission = new Permission();
                    $permission->setRole($roleDAO->show("id", $_POST["role_id"]));
                    $permission->setFuncAction($funcActionDAO->show("id", $_POST["func_action_id"]));
                    $permissionDAO->add($permission);
                    goToShowAllAndShowSuccess("Asignación de permiso añadida correctamente.");
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
        if (HavePermission("Permission", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $permissionDAO->delete($permissionPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Asignación de permiso eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $permissionDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar asignación de permiso", "¿Está seguro de que desea eliminar " .
                        "la asignación de permiso %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/PermissionController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Permission", "SHOWCURRENT")) {
            try {
                $permissionData = $permissionDAO->show($permissionPrimaryKey, $value);
                new PermissionShowView($permissionData);
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
        if (HavePermission("Permission", "EDIT")) {
            try {
                $permission = $permissionDAO->show($permissionPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new PermissionEditView($permission, $rolesData, $funcActionsData);
                } else {
                    $permission->setId($value);
                    $permission->setRole($roleDAO->show("id", $_POST["role_id"]));
                    $permission->setFuncAction($funcActionDAO->show("id", $_POST["func_action_id"]));
                    $permissionDAO->edit($permission);
                    goToShowAllAndShowSuccess("Asignación de permiso editada correctamente.");
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
        if (HavePermission("Permission", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new PermissionSearchView($rolesData, $funcActionsData);
            } else {
                try {
                    $permission = new Permission();
                    if(!empty($_POST["role_id"])) {
                        $permission->setRole($roleDAO->show('id', $_POST["role_id"]));
                    }
                    if(!empty($_POST["func_action_id"])) {
                        $permission->setFuncAction($funcActionDAO->show('id', $_POST["func_action_id"]));
                    }
                    showAllSearch($permission);
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
    if (HavePermission("Permission", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalPermissions = $GLOBALS["permissionDAO"]->countTotalPermissions($toSearch);
            $permissionData = $GLOBALS["permissionDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new PermissionShowAllView($permissionData, $itemsPerPage, $currentPage, $totalPermissions, $toSearch);
        } catch (DAOException $e) {
            new PermissionShowAllView(array());
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