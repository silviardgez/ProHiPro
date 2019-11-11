<?php
include_once "../Models/UserRole/UserRoleDAO.php";
include_once "../Models/FuncAction/FuncActionDAO.php";
include_once "../Models/Functionality/FunctionalityDAO.php";
include_once "../Models/Action/ActionDAO.php";
include_once "../Models/Permission/PermissionDAO.php";

function HavePermission($controller, $act)
{

    $funcActionDAO = new FuncActionDAO();
    $funcDAO = new FunctionalityDAO();
    $actionDAO = new ActionDAO();
    $permissionDAO = new PermissionDAO();
    $userRoleDAO = new UserRoleDAO();

    try{
        $userRoles = $userRoleDAO->showAll();
        foreach ($userRoles as $userRole) {
            if($userRole->getLogin() ==  $_SESSION['login']) {
                $permissions = $permissionDAO->showAll();
                foreach ($permissions as $permission) {
                    if ($permission->getIdRole() == $userRole->getIdRole()) {
                        $funcAction = $funcActionDAO->show("IdFuncAction", $permission->getIdFuncAction());
                        $func = $funcDAO->show("IdFunctionality", $funcAction->getIdFunctionality());
                        $action = $actionDAO->show("IdAction", $funcAction->getIdAction());
                        if ($func->getName() == $controller . "Management" && $action->getName() == $act) {
                            return true;
                        }
                    }

                }
            }
        }
        return false;
    }
    catch (DAOException $e){
        return false;
    }
}
