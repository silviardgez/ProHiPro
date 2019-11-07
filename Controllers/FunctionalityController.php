<?php
session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/HavePermission.php';
if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/Functionality/FunctionalityDAO.php';
include_once '../Models/Common/MessageType.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Functionality/FunctionalityShowAllView.php';
include_once '../Views/Functionality/FunctionalityAddView.php';
include_once '../Views/Functionality/FunctionalityShowView.php';
include_once '../Views/Functionality/FunctionalityEditView.php';
include_once '../Functions/ShowToast.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Functionality", "ADD")) {
            if (!isset($_POST["submit"])) {
                new FunctionalityAddView();
            } else {
                try {
                    $functionality = new Functionality();
                    $functionality->setIdFunctionality($_POST["IdFunctionality"]);
                    $functionality->setName($_POST["name"]);
                    $functionality->setDescription($_POST["description"]);
                    $functionalityDAO = new FunctionalityDAO();
                    $functionalityDAO->add($functionality);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Funcionalidad añadida correctamente.");
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
        if (HavePermission("Functionality", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $key = "IdFunctionality";
                    $value = $_REQUEST[$key];
                    $functionalityDAO = new FunctionalityDAO();
                    $response = $functionalityDAO->delete($key, $value);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Funcionalidad eliminada correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                }
            } else {
                showAll();
                $key = "IdFunctionality";
                $value = $_REQUEST[$key];
                openDeletionModal("Eliminar funcionalidad " . $value, "¿Está seguro de que desea eliminar " .
                    "la funcionalidad <b>" . $value . "</b>? Esta acción es permanente y no se puede recuperar.",
                    "../Controllers/FunctionalityController.php?action=delete&IdFunctionality=" . $value . "&confirm=true");
            }
        } else{
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "show":
        if (HavePermission("Functionality", "SHOWCURRENT")) {
            try {
                $key = "IdFunctionality";
                $value = $_REQUEST[$key];
                $functionalityDAO = new FunctionalityDAO();
                $functionalityData = $functionalityDAO->show($key, $value);
                new FunctionalityShowView($functionalityData);
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
        if (HavePermission("Functionality", "EDIT")) {
            $key = "IdFunctionality";
            $value = $_REQUEST[$key];
            $functionalityDAO = new FunctionalityDAO();
            try {
                $functionality = $functionalityDAO->show($key, $value);
                if (!isset($_POST["submit"])) {
                    new FunctionalityEditView($functionality);
                } else {
                    try {
                        $functionality->setName($_POST["name"]);
                        $functionality->setDescription($_POST["description"]);
                        $functionalityDAO = new FunctionalityDAO();
                        $response = $functionalityDAO->edit($functionality);
                        $message = MessageType::SUCCESS;
                        showAll();
                        showToast($message, "Funcionalidad editada correctamente.");
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
    if (HavePermission("Functionality", "SHOWALL")) {
        try {
            $functionalityDAO = new FunctionalityDAO();
            $functionalitiesData = $functionalityDAO->showAll();
            new FunctionalityShowAllView($functionalitiesData);
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            new FunctionalityShowAllView(array());
            showToast($message, $e->getMessage());
        }
    }  else{
        $message = MessageType::ERROR;
        showToast($message, "No tienes permiso para acceder");
    }
}