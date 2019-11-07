<?php

session_start();
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}
include '../Models/Role/RoleDAO.php';
include '../Models/Common/MessageType.php';
include '../Models/Common/DAOException.php';
include '../Views/Common/Head.php';
include '../Views/Common/DefaultView.php';
include '../Views/Role/RoleShowAllView.php';
include '../Views/Role/RoleAddView.php';
include '../Views/Role/RoleShowView.php';
include '../Views/Role/RoleEditView.php';
include '../Functions/ShowToast.php';
include '../Functions/OpenDeletionModal.php';
include '../Functions/Redirect.php';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($action) {
	case "add":
	       if (!isset($_POST["submit"])){
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
                showToast($message, "Role añadido correctamente.");
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        }
        break;
	case "delete":
	       if (isset($_REQUEST["confirm"])) {
            try {
                $key = "IdRole";
                $value = $_REQUEST[$key];
                $roleDAO = new RoleDAO();
                $response = $roleDAO->delete($key, $value);
                $message = MessageType::SUCCESS;
                showAll();
                showToast($message, "Role eliminado correctamente.");
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
        break;
	case "show":
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
        break;
    case "edit":
        $key = "IdRole";
        $value = $_REQUEST[$key];
        $roleDAO = new RoleDAO();
        try {
            $role = $roleDAO->show($key, $value);
            if (!isset($_POST["submit"])){
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
                    showToast($message, "Role editado correctamente.");
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
        break;
	default:
		showAll();
		break;	
}

function showAll() {
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