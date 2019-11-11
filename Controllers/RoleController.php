<?php

session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/HavePermission.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/Role/RoleDAO.php';
include_once '../Models/Common/MessageType.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Role/RoleShowAllView.php';
include_once '../Views/Role/RoleAddView.php';
include_once '../Views/Role/RoleShowView.php';
include_once '../Views/Role/RoleEditView.php';
include_once '../Functions/ShowToast.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Role", "ADD")) {
            if (!isset($_POST["submit"])) {
                new RoleAddView();
            } else {
                try {
                    $role = new Role();
                    $role->setIdRole($_POST["IdRole"]);
                    $role->setName($_POST["name"]);
                    $role->setDescription($_POST["description"]);

                    $roleDAO = new RoleDAO();
                    $roleDAO->add($role);
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
        if (HavePermission("Role", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $key = "IdRole";
                    $value = $_REQUEST[$key];
                    $roleDAO = new RoleDAO();
                    $response = $roleDAO->delete($key, $value);
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
                $key = "IdRole";
                $value = $_REQUEST[$key];
                openDeletionModal("Eliminar role " . $value, "¿Está seguro de que desea eliminar " .
                    "el role <b>" . $value . "</b>? Esta acción es permanente y no se puede recuperar.",
                    "../Controllers/RoleController.php?action=delete&IdRole=" . $value . "&confirm=true");
            }
        }
        break;
    case "show":
        if (HavePermission("Role", "SHOWCURRENT")) {
            try {
                $key = "IdRole";
                $value = $_REQUEST[$key];
                $roleDAO = new RoleDAO();
                $roleData = $roleDAO->show($key, $value);
                new RoleShowView($roleData);
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        }
        break;
    case "edit":
        if (HavePermission("Role", "EDIT")) {
            $key = "IdRole";
            $value = $_REQUEST[$key];
            $roleDAO = new RoleDAO();
            try {
                $role = $roleDAO->show($key, $value);
                if (!isset($_POST["submit"])) {
                    new RoleEditView($role);
                } else {
                    try {
                        $role->setIdRole($_POST["IdRole"]);
                        $role->setName($_POST["name"]);
                        $role->setDescription($_POST["description"]);

                        $roleDAO = new RoleDAO();
                        $response = $roleDAO->edit($role);
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
        if (HavePermission("Role", "SHOWALL")) {
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
        $roleDAO = new RoleDAO();
        $rolesData = $roleDAO->showAll();
        new RoleShowAllView($rolesData);
    } catch (DAOException $e) {
        $message = MessageType::ERROR;
        new RoleShowAllView(array());
        showToast($message, $e->getMessage());
    }
}