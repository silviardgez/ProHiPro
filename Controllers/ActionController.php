<?php

session_start();
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}
include '../Models/Action/ActionDAO.php';
include '../Models/Common/MessageType.php';
include '../Models/Common/DAOException.php';
include '../Views/Common/Head.php';
include '../Views/Common/DefaultView.php';
include '../Views/Action/ActionShowAllView.php';
include '../Views/Action/ActionAddView.php';
include '../Views/Action/ActionShowView.php';
include '../Views/Action/ActionEditView.php';
include '../Functions/ShowToast.php';
include '../Functions/OpenDeletionModal.php';
include '../Functions/Redirect.php';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($action) {
	case "add":
	       if (!isset($_POST["submit"])){
            new ActionAddView();
        } else {
            try {
                $action = new Action();
                $action->setIdAction($_POST["IdAction"]);
                $action->setName($_POST["name"]);
                $action->setDescription($_POST["description"]);

                $actionDAO = new ActionDAO();
                $actionDAO->add($action);
                $message = MessageType::SUCCESS;
                showAll();
                showToast($message, "Acción añadida correctamente.");
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
                $key = "IdAction";
                $value = $_REQUEST[$key];
                $actionDAO = new ActionDAO();
                $response = $actionDAO->delete($key, $value);
                $message = MessageType::SUCCESS;
                showAll();
                showToast($message, "Acción eliminada correctamente.");
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        } else {
            showAll();
            $key = "IdAction";
            $value = $_REQUEST[$key];
            openDeletionModal("Eliminar acción " . $value, "¿Está seguro de que desea eliminar " .
                "la acción <b>" . $value . "</b>? Esta acción es permanente y no se puede recuperar.",
            "../Controllers/ActionController.php?action=delete&IdAction=" . $value . "&confirm=true");
        }
        break;
	case "show":
        try {
            $key = "IdAction";
            $value = $_REQUEST[$key];
            $actionDAO = new ActionDAO();
            $actionData = $actionDAO->show($key, $value);
            new ActionShowView($actionData);
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            showAll();
            showToast($message, $e->getMessage());
        }
        break;
    case "edit":
        $key = "IdAction";
        $value = $_REQUEST[$key];
        $actionDAO = new ActionDAO();
        try {
            $action = $actionDAO->show($key, $value);
            if (!isset($_POST["submit"])){
                new ActionEditView($action);
            } else {
                try {
                    $action->setIdAction($_POST["IdAction"]);
                    $action->setName($_POST["name"]);
                    $action->setDescription($_POST["description"]);

                    $actionDAO = new ActionDAO();
                    $response = $actionDAO->edit($action);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Acción editada correctamente.");
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
        $actionDAO = new ActionDAO();
        $actionsData = $actionDAO->showAll();
        new ActionShowAllView($actionsData);
    } catch (DAOException $e) {
        $message = MessageType::ERROR;
        new ActionShowAllView(array());
        showToast($message, $e->getMessage());
    }
}