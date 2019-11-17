<?php
include_once "../Models/UserRole/UserRoleDAO.php";
include_once "../Models/Permission/PermissionDAO.php";

function IsAdmin()
{
    $permissionDAO = new PermissionDAO();
    $userRoleDAO = new UserRoleDAO();
    try{
        $userRoles = $userRoleDAO->showAll();
        foreach ($userRoles as $userRole) {
            if($userRole->getUser()->getLogin() ==  $_SESSION['login']) {
                $permissions = $permissionDAO->showAll();
                foreach ($permissions as $permission) {
                    if ($permission->getRole()->getId() == $userRole->getId()) {
                        if ($permission->getRole()->getName() =="Admin") {
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