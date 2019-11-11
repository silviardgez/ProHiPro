<?php

session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/HavePermission.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/User/UserDAO.php';
include_once '../Models/Role/RoleDAO.php';
include_once '../Models/UserRole/UserRoleDAO.php';
include_once '../Models/Common/MessageType.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/UserRole/UserRoleShowAllView.php';
include_once '../Views/UserRole/UserRoleAddView.php';
include_once '../Views/UserRole/UserRoleShowView.php';
include_once '../Views/UserRole/UserRoleEditView.php';
include_once '../Functions/ShowToast.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
$userRole = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($userRole) {
    case "add":
        if (HavePermission("UserRole", "ADD")) {
            if (!isset($_POST["submit"])) {
                $roleDAO = new RoleDAO();
                $userDAO = new UserDAO();
                $roleData = $roleDAO->showAll();
                $userData = $userDAO->showAll();
                new UserRoleAddView($userData, $roleData);
            } else {
                try {
                    $userRole = new User_Role();
                    $userRole->setLogin($_POST["login"]);
                    $userRole->setIdRole($_POST["idRole"]);

                    $userRoleDAO = new UserRoleDAO();

                    $allUserRole = $userRoleDAO->showAll();
                    foreach ($allUserRole as $usRo) {
                        if ($usRo->getLogin() == $userRole->getLogin() and $usRo->getIdRole() == $userRole->getIdRole()) {
                            throw new DAOException('Rol duplicado.');
                        }
                    }

                    $userRoleDAO->add($userRole);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Rol añadido correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                }
            }
        }
        break;
    case "delete":
        if (HavePermission("UserRole", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $key = "IdUserRole";
                    $value = $_REQUEST[$key];
                    $userRoleDAO = new UserRoleDAO();
                    $response = $userRoleDAO->delete($key, $value);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Rol eliminado correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                }
            } else {
                showAll();
                $key = "IdUserRole";
                $value = $_REQUEST[$key];
                openDeletionModal("Eliminar rol " . $value, "¿Está seguro de que desea eliminar " .
                    "el rol <b>" . $value . "</b>? Esta acción es permanente y no se puede recuperar.",
                    "../Controllers/UserRoleController.php?action=delete&IdUserRole=" . $value . "&confirm=true");
            }
        }
        break;
    case "show":
        if (HavePermission("UserRole", "SHOWCURRENT")) {
            try {
                $key = "IdUserRole";
                $value = $_REQUEST[$key];
                $userRoleDAO = new UserRoleDAO();
                $roleDAO = new RoleDAO();
                $roleData = $roleDAO->showAll();
                $userRoleData = $userRoleDAO->show($key, $value);
                new UserRoleShowView($userRoleData, $roleData);
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        }
        break;
    case "edit":
        if (HavePermission("UserRole", "EDIT")) {
            $key = "IdUserRole";
            $value = $_REQUEST[$key];
            $userRoleDAO = new UserRoleDAO();
            try {
                $userRole = $userRoleDAO->show($key, $value);
                if (!isset($_POST["submit"])) {
                    $roleDAO = new RoleDAO();
                    $userDAO = new UserDAO();
                    $roleData = $roleDAO->showAll();
                    $userData = $userDAO->showAll();
                    new UserRoleEditView($userRole, $userData, $roleData);
                } else {
                    try {
                        $userRole->setIdUserRole($value);
                        $userRole->setLogin($_POST["login"]);
                        $userRole->setIdRole($_POST["idRole"]);

                        $userRoleDAO = new UserRoleDAO();

                        $allUserRole = $userRoleDAO->showAll();
                        foreach ($allUserRole as $usRo) {
                            if ($usRo->getLogin() == $userRole->getLogin() and $usRo->getIdRole() == $userRole->getIdRole()) {
                                throw new DAOException('Rol duplicado.');
                            }
                        }

                        $response = $userRoleDAO->edit($userRole);
                        $message = MessageType::SUCCESS;
                        showAll();
                        showToast($message, "Rol editado correctamente.");
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
        }
        break;
    default:
        if (HavePermission("UserRole", "SHOWALL")) {
            showAll();
        } else {
            $message = MessageType::ERROR;
            showToast($message, "Access Denied");
            redirect("./IndexController.php");
        }
        break;
}

function showAll()
{
    try {
        $userRoleDAO = new UserRoleDAO();
        $roleDAO = new RoleDAO();
        $userRoleData = $userRoleDAO->showAll();
        $roleData = $roleDAO->showAll();
        new UserRoleShowAllView($userRoleData, $roleData);
    } catch (DAOException $e) {
        $message = MessageType::ERROR;
        new UserRoleShowAllView(array());
        showToast($message, $e->getMessage());
    }
}
