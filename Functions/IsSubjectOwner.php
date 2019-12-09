<?php
include_once "../Models/Subject/SubjectDAO.php";
include_once "../Models/Subject/Subject.php";

function IsSubjectOwner()
{
    $toret = array();
    $subjectDAO = new SubjectDAO();
    try {
        $subjects = $subjectDAO->showAll();
        foreach ($subjects as $subject) {
            if (!empty($subject->getTeacher()->getUser()) && $subject->getTeacher()->getUser()->getId() == $_SESSION['login']) {
                array_push($toret, $subject);
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