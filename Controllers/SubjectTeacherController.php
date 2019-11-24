<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/SubjectTeacher/SubjectTeacherDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Subject/SubjectDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/SubjectTeacher/SubjectTeacherShowAllView.php';
include_once '../Views/SubjectTeacher/SubjectTeacherAddView.php';
include_once '../Views/SubjectTeacher/SubjectTeacherEditView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$subjectTeacherDAO = new SubjectTeacherDAO();
$teacherDAO = new TeacherDAO();
$subjectDAO = new SubjectDAO();

//Data required
$teacherData = $teacherDAO->showAll();

$subjectTeacherPrimaryKey = "id";
$value = $_REQUEST[$subjectTeacherPrimaryKey];
$subject = $_REQUEST["subject_id"];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("SubjectTeacher", "ADD")) {
            if (!isset($_POST["submit"])) {
                new SubjectTeacherAddView($teacherData, $subject);
            } else {
                try {
                    $subjectTeacher = new SubjectTeacher();
                    $subjectTeacher->setHours($_POST["hours"]);
                    $subjectTeacher->setTeacher($teacherDAO->show("id",$_POST["teacher_id"]));
                    $subjectTeacher->setSubject($subjectDAO->show("id", $subject));
                    $subjectTeacherDAO->add($subjectTeacher);
                    goToShowAllAndShowSuccess("Profesor añadido correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.");
        }
        break;
    case "delete":
        if (HavePermission("SubjectTeacher", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $subjectTeacherDAO->delete($subjectTeacherPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Profesor eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $subjectTeacherDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar profesor", "¿Está seguro de que desea eliminar " .
                        "el profesor %" . $value . "% de esta asignatura? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/SubjectTeacherController.php?action=delete&id=" . $value . "&confirm=true&subject_id=" . $subject);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "edit":
        if (HavePermission("SubjectTeacher", "EDIT")) {
            try {
                $subjectTeacher = $subjectTeacherDAO->show($subjectTeacherPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new SubjectTeacherEditView($subjectTeacher, $teacherData, $subject);
                } else {
                    $subjectTeacher->setId($value);
                    $subjectTeacher->setHours($_POST["hours"]);
                    $subjectTeacher->setTeacher($teacherDAO->show("id",$_POST["teacher_id"]));
                    $subjectTeacher->setSubject($subjectDAO->show("id", $subject));
                    $subjectTeacherDAO->edit($subjectTeacher);
                    goToShowAllAndShowSuccess("Profesor editado correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else{
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    default:
        showAll();
        break;
}

function showAll() {
    $subjectTeacher = new SubjectTeacher();
    $subjectTeacher->setSubject($GLOBALS["subjectDAO"]->show("id", $GLOBALS["subject"]));
    showAllSearch($subjectTeacher);
}

function showAllSearch($search) {
    if (HavePermission("SubjectTeacher", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalTeachers = $GLOBALS["subjectTeacherDAO"]->countTotalSubjectTeachers($toSearch);
            $teachersData = $GLOBALS["subjectTeacherDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new SubjectTeacherShowAllView($teachersData, $itemsPerPage, $currentPage, $totalTeachers, $toSearch);
        } catch (DAOException $e) {
            new SubjectTeacherShowAllView(array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message) {
    showAll();
    errorMessage($message);
}

function goToShowAllAndShowSuccess($message) {
    showAll();
    successMessage($message);
}