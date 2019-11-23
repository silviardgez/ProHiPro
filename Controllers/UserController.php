<?php
session_start();
include_once '../Functions/Authentication.php';
if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/User/UserShowAllView.php';
include_once '../Views/User/UserAddView.php';
include_once '../Views/User/UserShowView.php';
include_once '../Views/User/UserEditView.php';
include_once '../Views/User/UserSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';
//DAO
$userDAO = new UserDAO();
$userPrimaryKey = "login";
$value = $_REQUEST[$userPrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("User", "ADD")) {
            if (!isset($_POST["submit"])) {
                new UserAddView();
            } else {
                try {
                    $user = new User();
                    $user->setLogin($_POST["login"]);
                    $user->setPassword($user->encryptPassword($_POST["password"]));
                    $user->setDni($_POST["dni"]);
                    $user->setName($_POST["name"]);
                    $user->setSurname($_POST["surname"]);
                    $user->setEmail($_POST["email"]);
                    $user->setAddress($_POST["address"]);
                    $user->setTelephone($_POST["telephone"]);
                    $userDAO->add($user);
                    goToShowAllAndShowSuccess("Usuario añadido correctamente.");
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
        if (HavePermission("User", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $userDAO->delete($userPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Usuario eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $userDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar usuario", "¿Está seguro de que desea eliminar " .
                        "el usuario %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/UserController.php?action=delete&login=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("User", "SHOWCURRENT")) {
            try {
                $userData = $userDAO->show($userPrimaryKey, $value);
                new UserShowView($userData);
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
        if (HavePermission("User", "EDIT")) {
            try {
                $user = $userDAO->show($userPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new UserEditView($user);
                } else {
                    if (!empty($_POST["password"])) {
                        $user->setPassword($user->encryptPassword($_POST["password"]));
                    }
                    $user->setDni($_POST["dni"]);
                    $user->setName($_POST["name"]);
                    $user->setSurname($_POST["surname"]);
                    $user->setEmail($_POST["email"]);
                    $user->setAddress($_POST["address"]);
                    $user->setTelephone($_POST["telephone"]);
                    $userDAO->edit($user);
                    goToShowAllAndShowSuccess("Usuario editado correctamente.");
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
        if (HavePermission("User", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new UserSearchView();
            } else {
                try {
                    $user = new User();
                    if(!empty($_POST["login"])) {
                        $user->setLogin($_POST["login"]);
                    }
                    if(!empty($_POST["dni"])) {
                        $user->setDni($_POST["dni"]);
                    }
                    if(!empty($_POST["name"])) {
                        $user->setName($_POST["name"]);
                    }
                    if(!empty($_POST["surname"])) {
                        $user->setSurname($_POST["surname"]);
                    }
                    if(!empty($_POST["email"])) {
                        $user->setEmail($_POST["email"]);
                    }
                    if(!empty($_POST["address"])) {
                        $user->setAddress($_POST["address"]);
                    }
                    if(!empty($_POST["telephone"])) {
                        $user->setTelephone($_POST["telephone"]);
                    }
                    showAllSearch($user);
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
function showAllSearch($search) {
    if (HavePermission("User", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $usersData = $GLOBALS["userDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            $totalUsers = $GLOBALS["userDAO"]->countTotalUsers($toSearch);
            new UserShowAllView($usersData, $itemsPerPage, $currentPage, $totalUsers, $toSearch);
        } catch (DAOException $e) {
            new UserShowAllView(array());
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