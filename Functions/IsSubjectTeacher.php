<?php
include_once "../Models/SubjectTeacher/SubjectTeacherDAO.php";
include_once "../Models/SubjectTeacher/SubjectTeacher.php";

function IsSubjectTeacher()
{
    $toret = array();
    $subjectDAO = new SubjectTeacherDAO();
    try {
        $subjects = $subjectDAO->showAll();
        foreach ($subjects as $subject) {
            if ($subject->getTeacher()->getUser()->getId() == $_SESSION['login']) {
                array_push($toret, $subject->getSubject());
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