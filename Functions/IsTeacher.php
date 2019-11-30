<?php
include_once "../Models/Teacher/TeacherDAO.php";
include_once "../Models/User/UserDAO.php";
include_once "../Models/Teacher/Teacher.php";

function IsTeacher()
{
    $teacherDAO = new TeacherDAO();
    $userDAO = new UserDAO();
    try {
        $teachers = $teacherDAO->showAll();
        foreach ($teachers as $teacher){
            if($teacher->getUser()->getLogin() == $_SESSION['login']){
                return true;
            }
        }
        return false;
    } catch (DAOException $e) {
        return false;
    }
}