<?php
session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/HavePermission.php';
if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/User/UserDAO.php';
include_once '../Models/UserRole/UserRoleDAO.php';
include_once '../Models/Common/MessageType.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/User/UserShowAllView.php';
include_once '../Views/User/UserAddView.php';
include_once '../Views/User/UserShowView.php';
include_once '../Views/User/UserEditView.php';
include_once '../Views/User/UserSearchView.php';
include_once '../Functions/ShowToast.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/OpenDependenciesModal.php';
include_once '../Functions/Redirect.php';
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
                    $userDAO = new UserDAO();
                    $userDAO->add($user);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Usuario añadido correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                }
            }
        } else {
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "delete":
        if (HavePermission("User", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $key = "login";
                    $value = $_REQUEST[$key];
                    $userDAO = new UserDAO();
                    $response = $userDAO->delete($key, $value);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Usuario eliminado correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                }
            } else {
                showAll();
                $key = "login";
                $value = $_REQUEST[$key];
                $deletionDependencies = checkIfAbleToDelete($value);
                if (count($deletionDependencies) == 0) {
                    openDeletionModal("Eliminar usuario %" . $value . "%", "¿Está seguro de que desea eliminar " .
                        "el usuario %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/UserController.php?action=delete&login=" . $value . "&confirm=true");
                } else {
                    $dependecies = "";
                    foreach ($deletionDependencies as $entity => $id) {
                        $dependecies = $dependecies . "\t" . $entity . " (Id: " . $id . ")";
                    }
                    openDependenciesModal("No se puede borrar el elemento por las siguientes dependencias", $dependecies);
                }
            }
        } else {
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "show":
        if (HavePermission("User", "SHOWCURRENT")) {
            try {
                $key = "login";
                $value = $_REQUEST[$key];
                $userDAO = new UserDAO();
                $userData = $userDAO->show($key, $value);
                new UserShowView($userData);
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        } else {
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "edit":
        if (HavePermission("User", "EDIT")) {
            $key = "login";
            $value = $_REQUEST[$key];
            $userDAO = new UserDAO();
            try {
                $user = $userDAO->show($key, $value);
                if (!isset($_POST["submit"])) {
                    new UserEditView($user);
                } else {
                    try {
                        if (!empty($_POST["password"])) {
                            $user->setPassword($user->encryptPassword($_POST["password"]));
                        }
                        $user->setDni($_POST["dni"]);
                        $user->setName($_POST["name"]);
                        $user->setSurname($_POST["surname"]);
                        $user->setEmail($_POST["email"]);
                        $user->setAddress($_POST["address"]);
                        $user->setTelephone($_POST["telephone"]);
                        $userDAO = new UserDAO();
                        $response = $userDAO->edit($user);
                        $message = MessageType::SUCCESS;
                        showAll();
                        showToast($message, "Usuario editado correctamente.");
                    } catch (DAOException $e) {
                        $message = MessageType::ERROR;
                        showAll();
                        showToast($message, $e->getMessage());
                    }
                }
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        } else {
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "search":
        if (HavePermission("User", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new UserSearchView();
            } else {
                try {
                    $user = new User();
                    $user->setLogin($_POST["login"]);
                    $user->setDni($_POST["dni"]);
                    $user->setName($_POST["name"]);
                    $user->setSurname($_POST["surname"]);
                    $user->setEmail($_POST["email"]);
                    $user->setAddress($_POST["address"]);
                    $user->setTelephone($_POST["telephone"]);
                    showAllSearch($user);
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                }
            }
        } else {
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    default:
        showAll();
        break;
}
function checkIfAbleToDelete($id)
{
    $dependencies = array();
    try {
        $userRoleDAO = new UserRoleDAO();
        $userRole = $userRoleDAO->show('login', $id);
        $dependencies["UserRole"] = $userRole->getIdUserRole();
    } catch (DAOException $e) {
    }
    return $dependencies;
}
function showAll()
{
    showAllSearch(NULL);
}
function showAllSearch($search)
{
    if (HavePermission("Permission", "SHOWALL")) {
        try {
            $userDAO = new UserDAO();
            if (!empty($_REQUEST['currentPage'])) {
                $currentPage = $_REQUEST['currentPage'];
            } else {
                $currentPage = 1;
            }
            if (!empty($_REQUEST['itemsPerPage'])) {
                $itemsPerPage = $_REQUEST['itemsPerPage'];
            } else {
                $itemsPerPage = 10;
            }
            $searchRequested = $_REQUEST['search'];
            if (!empty($searchRequested)) {
                $toSearch = $searchRequested;
            } elseif (!is_null($search)) {
                $toSearch = $search;
            } else {
                $toSearch = NULL;
            }
            $totalUsers = $userDAO->countTotalUsers($toSearch);
            $usersData = $userDAO->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new UserShowAllView($usersData, $itemsPerPage, $currentPage, $totalUsers, $toSearch);
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            new UserShowAllView(array());
            showToast($message, $e->getMessage());
        }
    } else {
        $message = MessageType::ERROR;
        showToast($message, "No tienes permiso para acceder");
    }
}
