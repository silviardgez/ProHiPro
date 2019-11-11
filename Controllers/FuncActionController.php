<?php

session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/HavePermission.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/FuncAction/FuncActionDAO.php';
include_once '../Models/Permission/PermissionDAO.php';
include_once '../Models/Action/ActionDAO.php';
include_once '../Models/Functionality/FunctionalityDAO.php';
include_once '../Models/Common/MessageType.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/FuncAction/FuncActionShowAllView.php';
include_once '../Views/FuncAction/FuncActionAddView.php';
include_once '../Views/FuncAction/FuncActionShowView.php';
include_once '../Views/FuncAction/FuncActionEditView.php';
include_once '../Functions/ShowToast.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/OpenDependenciesModal.php';
include_once '../Functions/Redirect.php';
$funcAction = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($funcAction) {
    case "add":
        if (HavePermission("FuncAction", "ADD")) {
            if (!isset($_POST["submit"])) {
                $actionDAO = new ActionDAO();
                $funcDAO = new FunctionalityDAO();
                $actionsData = $actionDAO->showAll();
                $functionalitiesData = $funcDAO->showAll();
                new FuncActionAddView($actionsData, $functionalitiesData);
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
                            throw new DAOException('Accion-funcionalidad duplicada.');
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
        } else {
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "delete":
        if (HavePermission("FuncAction", "DELETE")) {
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
                $deletionDependencies = checkIfAbleToDelete($value);
                if (count($deletionDependencies) == 0) {
                    openDeletionModal("Eliminar acción-función " . $value, "¿Está seguro de que desea eliminar " .
                        "la acción-funcionalidad <b>" . $value . "</b>? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/FuncActionController.php?action=delete&IdFuncAction=" . $value . "&confirm=true");
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
        if (HavePermission("FuncAction", "SHOWCURRENT")) {
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
        } else {
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "edit":
        if (HavePermission("FuncAction", "EDIT")) {
            $key = "IdFuncAction";
            $value = $_REQUEST[$key];
            $funcActionDAO = new FuncActionDAO();
            try {
                $funcAction = $funcActionDAO->show($key, $value);
                if (!isset($_POST["submit"])) {
                    $actionDAO = new ActionDAO();
                    $funcDAO = new FunctionalityDAO();
                    $actionsData = $actionDAO->showAll();
                    $functionalitiesData = $funcDAO->showAll();
                    new FuncActionEditView($funcAction, $actionsData, $functionalitiesData);
                } else {
                    try {
                        $funcAction->setIdFuncAction($value);
                        $funcAction->setIdAction($_POST["idAction"]);
                        $funcAction->setIdFunctionality($_POST["idFunctionality"]);

                        $funcActionDAO = new FuncActionDAO();

                        $allFuncActions = $funcActionDAO->showAll();
                        foreach ($allFuncActions as $funAct) {
                            if ($funAct->getIdAction() == $funcAction->getIdAction() and $funAct->getIdFunctionality() == $funcAction->getIdFunctionality()) {
                                throw new DAOException('Accion-funcionalidad duplicada.');
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
        $permissionDAO = new PermissionDAO();
        $permission = $permissionDAO->show('IdFuncAction', $id);
        $dependencies["Permission"] = $permission->getIdPermission();
    } catch (DAOException $e) {
    }
    return $dependencies;
}


function showAll()
{
    if (HavePermission("FuncAction", "SHOWALL")) {
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
    } else {
        $message = MessageType::ERROR;
        showToast($message, "No tienes permiso para acceder");
    }

}
