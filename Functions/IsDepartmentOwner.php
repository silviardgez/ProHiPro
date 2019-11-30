<?php
include_once "../Models/Department/DepartmentDAO.php";
include_once "../Models/Department/Department.php";

function IsDepartmentOwner()
{
    $toret = array();
    $departmentDAO = new DepartmentDAO();
    try {
        $departments = $departmentDAO->showAll();
        foreach ($departments as $department) {
            if ($department->getTeacher()->getUser()->getId() == $_SESSION['login']) {
                array_push($toret, $department);
            }
        }
        if (empty($toret)) {
            return false;
        } else {
            return $toret;
        }
    } catch (DAOException $e) {
        return false;
    }
}