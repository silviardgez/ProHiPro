<?php
session_start();
include_once '../Functions/Authentication.php';
if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/User/UserDAO.php';
include_once '../Models/Role/RoleDAO.php';
include_once '../Models/UserRole/UserRoleDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/UserRole/UserRoleShowAllView.php';
include_once '../Views/UserRole/UserRoleAddView.php';
include_once '../Views/UserRole/UserRoleShowView.php';
include_once '../Views/UserRole/UserRoleEditView.php';
include_once '../Views/UserRole/UserRoleSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';
//DAOS
$userRoleDAO = new UserRoleDAO();
$roleDAO = new RoleDAO();
$userDAO = new UserDAO();
//Data required
$roleData = $roleDAO->showAll();
$userData = $userDAO->showAll();
$userRolePrimaryKey = "id";
$value = $_REQUEST[$userRolePrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("UserRole", "ADD")) {
            if (!isset($_POST["submit"])) {
                new UserRoleAddView($userData, $roleData);
            } else {
                try {
                    $userRole = new UserRole();
                    $userRole->setUser($userDAO->show("login", $_POST["user_id"]));
                    $userRole->setRole($roleDAO->show("id", $_POST["role_id"]));
                    $userRoleDAO->add($userRole);
                    goToShowAllAndShowSuccess("Rol añadido correctamente.");
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
        if (HavePermission("UserRole", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $userRoleDAO->delete($userRolePrimaryKey, $value);
                    goToShowAllAndShowSuccess("Rol eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $userRoleDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar asignación de rol a usuario", "¿Está seguro de que desea eliminar " .
                        "el usuario-rol %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/UserRoleController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("UserRole", "SHOWCURRENT")) {
            try {
                $userRoleData = $userRoleDAO->show($userRolePrimaryKey, $value);
                new UserRoleShowView($userRoleData);
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
        if (HavePermission("UserRole", "EDIT")) {
            try {
                $userRole = $userRoleDAO->show($userRolePrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new UserRoleEditView($userRole, $userData, $roleData);
                } else {
                    $userRole->setId($value);
                    $userRole->setUser($userDAO->show("login", $_POST["user_id"]));
                    $userRole->setRole($roleDAO->show("id", $_POST["role_id"]));
                    $userRoleDAO->edit($userRole);
                    goToShowAllAndShowSuccess("Rol editado correctamente.");
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
        if (HavePermission("UserRole", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new UserRoleSearchView($userData, $roleData);
            } else {
                try {
                    $userRole = new UserRole();
                    if(!empty($_POST["user_id"])) {
                        $userRole->setUser($userDAO->show("login", $_POST["user_id"]));
                    }
                    if(!empty($_POST["role_id"])) {
                        $userRole->setRole($roleDAO->show("id", $_POST["role_id"]));
                    }
                    showAllSearch($userRole);
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
    if (HavePermission("UserRole", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalUserRoles = $GLOBALS["userRoleDAO"]->countTotalUserRoles($toSearch);
            $userRolesData = $GLOBALS["userRoleDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new UserRoleShowAllView($userRolesData, $itemsPerPage, $currentPage, $totalUserRoles, $toSearch);
        } catch (DAOException $e) {
            new UserRoleShowAllView(array());
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