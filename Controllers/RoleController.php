<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Role/RoleDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Role/RoleShowAllView.php';
include_once '../Views/Role/RoleAddView.php';
include_once '../Views/Role/RoleShowView.php';
include_once '../Views/Role/RoleEditView.php';
include_once '../Views/Role/RoleSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAO
$roleDAO = new RoleDAO();

$rolePrimaryKey = "id";
$value = $_REQUEST[$rolePrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Role", "ADD")) {
            if (!isset($_POST["submit"])) {
                new RoleAddView();
            } else {
                try {
                    $role = new Role();
                    $role->setName($_POST["name"]);
                    $role->setDescription($_POST["description"]);
                    $roleDAO->add($role);
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
        if (HavePermission("Role", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $roleDAO->delete($rolePrimaryKey, $value);
                    goToShowAllAndShowSuccess("Rol eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $roleDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar rol", "¿Está seguro de que desea eliminar " .
                        "el rol %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/RoleController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Role", "SHOWCURRENT")) {
            try {
                $roleData = $roleDAO->show($rolePrimaryKey, $value);
                new RoleShowView($roleData);
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
        if (HavePermission("Role", "EDIT")) {
            try {
                $role = $roleDAO->show($rolePrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new RoleEditView($role);
                } else {
                    $role->setId($value);
                    $role->setName($_POST["name"]);
                    $role->setDescription($_POST["description"]);
                    $roleDAO->edit($role);
                    goToShowAllAndShowSuccess("Rol editado correctamente.");
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
        if (HavePermission("Role", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new RoleSearchView();
            } else {
                try {
                    $role = new Role();
                    if(!empty($_POST["name"])) {
                        $role->setName($_POST["name"]);
                    }
                    if(!empty($_POST["description"])) {
                        $role->setDescription($_POST["description"]);
                    }
                    showAllSearch($role);
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
    if (HavePermission("Role", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalRoles = $GLOBALS["roleDAO"]->countTotalRoles($toSearch);
            $rolesData = $GLOBALS["roleDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new RoleShowAllView($rolesData, $itemsPerPage, $currentPage, $totalRoles, $toSearch);
        } catch (DAOException $e) {
            new RoleShowAllView(array());
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