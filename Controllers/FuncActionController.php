<?php

session_start();
include '../Functions/Authentication.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}
include '../Models/FuncAction/FuncActionDAO.php';
include '../Models/Action/ActionDAO.php';
include '../Models/Functionality/FunctionalityDAO.php';
include '../Models/Common/MessageType.php';
include '../Models/Common/DAOException.php';
include '../Views/Common/Head.php';
include '../Views/Common/DefaultView.php';
include '../Views/FuncAction/FuncActionShowAllView.php';
include '../Views/FuncAction/FuncActionAddView.php';
include '../Views/FuncAction/FuncActionShowView.php';
include '../Views/FuncAction/FuncActionEditView.php';
include '../Functions/ShowToast.php';
include '../Functions/OpenDeletionModal.php';
include '../Functions/Redirect.php';
$funcAction = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($funcAction) {
    case "add":
        if (!isset($_POST["submit"])){
            $actionDAO = new ActionDAO();
            $funcDAO = new FunctionalityDAO();
            $actionsData = $actionDAO->showAll();
            $functionalitiesData = $funcDAO->showAll();
            new FuncActionAddView($actionsData,$functionalitiesData);
        } else {
            try {
                $funcAction = new Func_Action();
                $funcAction->setIdAction($_POST["idAction"]);
                $funcAction->setIdFunctionality($_POST["idFunctionality"]);

                echo $funcAction->getIdAction();
                echo $funcAction->getIdFunctionality();

                $funcActionDAO = new FuncActionDAO();

                $allFuncActions = $funcActionDAO->showAll();
                foreach ($allFuncActions as $funAct) {
                    if ($funAct->getIdAction() == $funcAction->getIdAction() and $funAct->getIdFunctionality() == $funcAction->getIdFunctionality()) {
                        throw new DAOException('Accion-funcionalidad duplicado.');
                    }
                }

                $funcActionDAO->add($funcAction);
                $message = MessageType::SUCCESS;
                showAll();
                showToast($message, "Acción-funcionalidad añadida correctamente.");
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
                $key = "IdFuncAction";
                $value = $_REQUEST[$key];
                $funcActionDAO = new FuncActionDAO();
                $response = $funcActionDAO->delete($key, $value);
                $message = MessageType::SUCCESS;
                showAll();
                showToast($message, "Acción-funcionalidad eliminada correctamente.");
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        } else {
            showAll();
            $key = "IdFuncAction";
            $value = $_REQUEST[$key];
            openDeletionModal("Eliminar acción-función " . $value, "¿Está seguro de que desea eliminar " .
                "la acción-funcionalidad <b>" . $value . "</b>? Esta acción es permanente y no se puede recuperar.",
                "../Controllers/FuncActionController.php?action=delete&IdFuncAction=" . $value . "&confirm=true");
        }
        break;
    case "show":
        try {
            $key = "IdFuncAction";
            $value = $_REQUEST[$key];
            $funcActionDAO = new FuncActionDAO();
            $actionDAO = new ActionDAO();
            $funcDAO = new FunctionalityDAO();
            $actionsData = $actionDAO->showAll();
            $functionalitiesData = $funcDAO->showAll();
            $funcActionData = $funcActionDAO->show($key, $value);
            new FuncActionShowView($funcActionData, $actionsData, $functionalitiesData);
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            showAll();
            showToast($message, $e->getMessage());
        }
        break;
    case "edit":
        $key = "IdFuncAction";
        $value = $_REQUEST[$key];
        $funcActionDAO = new FuncActionDAO();
        try {
            $funcAction = $funcActionDAO->show($key, $value);
            if (!isset($_POST["submit"])){
                $actionDAO = new ActionDAO();
                $funcDAO = new FunctionalityDAO();
                $actionsData = $actionDAO->showAll();
                $functionalitiesData = $funcDAO->showAll();
                new FuncActionEditView($funcAction,$actionsData,$functionalitiesData);
            } else {
                try {
                    $funcAction->setIdFuncAction($value);
                    $funcAction->setIdAction($_POST["idAction"]);
                    $funcAction->setIdFunctionality($_POST["idFunctionality"]);

                    $funcActionDAO = new FuncActionDAO();

                    $allFuncActions = $funcActionDAO->showAll();
                    foreach ($allFuncActions as $funAct) {
                        if ($funAct->getIdAction() == $funcAction->getIdAction() and $funAct->getIdFunctionality() == $funcAction->getIdFunctionality()) {
                            throw new DAOException('Accion-funcionalidad duplicado.');
                        }
                    }

                    $response = $funcActionDAO->edit($funcAction);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Acción-funcionalidad editada correctamente.");
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
        $funcActionDAO = new FuncActionDAO();
        $actionDAO = new ActionDAO();
        $funcDAO = new FunctionalityDAO();
        $funcActionsData = $funcActionDAO->showAll();
        $actionsData = $actionDAO->showAll();
        $functionalitiesData = $funcDAO->showAll();
        new FuncActionShowAllView($funcActionsData, $actionsData, $functionalitiesData);
    } catch (DAOException $e) {
        $message = MessageType::ERROR;
        new UserRoleShowAllView(array());
        showToast($message, $e->getMessage());
    }
}
