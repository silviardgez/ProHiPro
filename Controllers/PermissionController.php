<?php

session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/HavePermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}
include_once '../Models/FuncAction/FuncActionDAO.php';
include_once '../Models/Action/ActionDAO.php';
include_once '../Models/Functionality/FunctionalityDAO.php';
include_once '../Models/Permission/PermissionDAO.php';
include_once '../Models/Role/RoleDAO.php';
include_once '../Models/Common/MessageType.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Permission/PermissionShowAllView.php';
include_once '../Views/Permission/PermissionAddView.php';
include_once '../Views/Permission/PermissionShowView.php';
include_once '../Views/Permission/PermissionEditView.php';
include_once '../Functions/ShowToast.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
$permission = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($permission) {
    case "add":
        if(HavePermission("Permission", "ADD")) {
            if (!isset($_POST["submit"])) {
                $actionDAO = new ActionDAO();
                $funcDAO = new FunctionalityDAO();
                $actionsData = $actionDAO->showAll();
                $functionalitiesData = $funcDAO->showAll();
                $funcActionDAO = new FuncActionDAO();
                $funcActionData = $funcActionDAO->showAll();
                $roleDAO = new RoleDAO();
                $roleData = $roleDAO->showAll();
                new PermissionAddView($roleData, $funcActionData, $actionsData, $functionalitiesData);
            } else {
                try {
                    $permission = new Permission();
                    $permission->setIdRole($_POST["idRole"]);
                    $permission->setIdFuncAction($_POST["idFuncAction"]);
                    $permissionDAO = new PermissionDAO();

                    $allPermissions = $permissionDAO->showAll();
                    foreach ($allPermissions as $permis) {
                        if ($permis->getIdRole() == $permission->getIdRole() and $permis->getIdFuncAction() == $permission->getIdFuncAction()) {
                            throw new DAOException('Permiso duplicado.');
                        }
                    }
                    $permissionDAO->add($permission);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Permiso añadido correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                }
            }
        }
        break;
    case "delete":
        if(HavePermission("Permission", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $key = "IdPermission";
                    $value = $_REQUEST[$key];
                    $permissionDAO = new PermissionDAO();
                    $response = $permissionDAO->delete($key, $value);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Permiso eliminado correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                }
            } else {
                showAll();
                $key = "IdPermission";
                $value = $_REQUEST[$key];
                openDeletionModal("Eliminar Permiso " . $value, "¿Está seguro de que desea eliminar " .
                    "el permiso <b>" . $value . "</b>? Esta acción es permanente y no se puede recuperar.",
                    "../Controllers/PermissionController.php?action=delete&IdPermission=" . $value . "&confirm=true");
            }
        }
        break;
    case "show":
        if(HavePermission("Permission", "SHOWCURRENT")) {
            try {
                $key = "IdPermission";
                $value = $_REQUEST[$key];
                $permissionDAO = new PermissionDAO();
                $funcActionDAO = new FuncActionDAO();
                $funcActionData = $funcActionDAO->showAll();
                $actionDAO = new ActionDAO();
                $funcDAO = new FunctionalityDAO();
                $actionsData = $actionDAO->showAll();
                $functionalitiesData = $funcDAO->showAll();
                $roleDAO = new RoleDAO();
                $roleData = $roleDAO->showAll();
                $permissionData = $permissionDAO->show($key, $value);
                new PermissionShowView($permissionData, $roleData, $funcActionData, $actionsData, $functionalitiesData);
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        }
        break;
    case "edit":
        if(HavePermission("Permission", "EDIT")) {
            $key = "IdPermission";
            $value = $_REQUEST[$key];
            $permissionDAO = new PermissionDAO();
            try {
                $permission = $permissionDAO->show($key, $value);
                if (!isset($_POST["submit"])) {
                    $actionDAO = new ActionDAO();
                    $funcDAO = new FunctionalityDAO();
                    $actionsData = $actionDAO->showAll();
                    $functionalitiesData = $funcDAO->showAll();
                    $funcActionDAO = new FuncActionDAO();
                    $funcActionData = $funcActionDAO->showAll();
                    $roleDAO = new RoleDAO();
                    $roleData = $roleDAO->showAll();
                    new PermissionEditView($permission, $roleData, $funcActionData, $actionsData, $functionalitiesData);
                } else {
                    try {
                        $permission->setIdPermission($value);
                        $permission->setIdRole($_POST["idRole"]);
                        $permission->setIdFuncAction($_POST["idFuncAction"]);

                        $permissionDAO = new PermissionDAO();

                        $allPermissions = $permissionDAO->showAll();
                        foreach ($allPermissions as $permis) {
                            if ($permis->getIdRole() == $permission->getIdRole() and $permis->getIdFuncAction() == $permission->getIdFuncAction()) {
                                throw new DAOException('Permiso duplicado.');
                            }
                        }

                        $response = $permissionDAO->edit($permission);
                        $message = MessageType::SUCCESS;
                        showAll();
                        showToast($message, "Permiso editado correctamente.");
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
        showAll();
        break;
}

function showAll() {
    if(HavePermission("Permission", "SHOWALL")) {
        try {
            $funcActionDAO = new FuncActionDAO();
            $actionDAO = new ActionDAO();
            $funcDAO = new FunctionalityDAO();
            $funcActionsData = $funcActionDAO->showAll();
            $actionsData = $actionDAO->showAll();
            $functionalitiesData = $funcDAO->showAll();
            $permissionDAO = new PermissionDAO();
            $permissionData = $permissionDAO->showAll();
            $roleDAO = new RoleDAO();
            $roleData = $roleDAO->showAll();
            new PermissionShowAllView($permissionData, $roleData, $funcActionsData, $actionsData, $functionalitiesData);
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            new UserRoleShowAllView(array());
            showToast($message, $e->getMessage());
        }
    } else{
        $message = MessageType::ERROR;
        showToast($message,"Access Denied");
        redirect("./IndexController.php");

    }
}
