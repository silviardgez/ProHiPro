<?php

session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/HavePermission.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/Action/ActionDAO.php';
include_once '../Models/Common/MessageType.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Action/ActionShowAllView.php';
include_once '../Views/Action/ActionAddView.php';
include_once '../Views/Action/ActionShowView.php';
include_once '../Views/Action/ActionEditView.php';
include_once '../Functions/ShowToast.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Action", "ADD")) {
            if (!isset($_POST["submit"])) {
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
        } else{
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "delete":
        if (HavePermission("Action", "DELETE")) {
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
        } else{
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "show":
        if (HavePermission("Action", "SHOWCURRENT")) {
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
        } else{
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "edit":
        if (HavePermission("Action", "EDIT")) {
            $key = "IdAction";
            $value = $_REQUEST[$key];
            $actionDAO = new ActionDAO();
            try {
                $action = $actionDAO->show($key, $value);
                if (!isset($_POST["submit"])) {
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
        } else{
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    default:
        showAll();
        break;
}

function showAll()
{
    if (HavePermission("Action", "SHOWALL")) {
        try {
            $actionDAO = new ActionDAO();
            $actionsData = $actionDAO->showAll();
            new ActionShowAllView($actionsData);
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            new ActionShowAllView(array());
            showToast($message, $e->getMessage());
        }
    } else{
        $message = MessageType::ERROR;
        showToast($message, "No tienes permiso para acceder");
    }

}