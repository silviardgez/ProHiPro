<?php

session_start();
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}
include '../Models/Functionality/FunctionalityDAO.php';
include '../Models/Common/MessageType.php';
include '../Models/Common/DAOException.php';
include '../Views/Common/Head.php';
include '../Views/Common/DefaultView.php';
include '../Views/Functionality/FunctionalityShowAllView.php';
include '../Views/Functionality/FunctionalityAddView.php';
include '../Views/Functionality/FunctionalityShowView.php';
include '../Views/Functionality/FunctionalityEditView.php';
include '../Functions/ShowToast.php';
include '../Functions/OpenDeletionModal.php';
include '../Functions/Redirect.php';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($action) {
    case "add":
        if (!isset($_POST["submit"])){
            new FunctionalityAddView();
        }
        else {
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
        break;
    case "delete":
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
        break;
    case "show":
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
        break;
    case "edit":
        $key = "IdFunctionality";
        $value = $_REQUEST[$key];
        $functionalityDAO = new FunctionalityDAO();
        try {
            $functionality = $functionalityDAO->show($key, $value);
            if (!isset($_POST["submit"])){
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
        break;
    default:
        showAll();
        break;
}

function showAll() {
    try {
        $functionalityDAO = new FunctionalityDAO();
        $functionalitiesData = $functionalityDAO->showAll();
        new FunctionalityShowAllView($functionalitiesData);
    } catch (DAOException $e) {
        $message = MessageType::ERROR;
        new FunctionalityShowAllView(array());
        showToast($message, $e->getMessage());
    }
}
