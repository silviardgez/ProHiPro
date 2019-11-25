<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Subject/SubjectDAO.php';
include_once '../Models/Department/DepartmentDAO.php';
include_once '../Models/Degree/DegreeDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Subject/SubjectShowAllView.php';
include_once '../Views/Subject/SubjectAddView.php';
include_once '../Views/Subject/SubjectShowView.php';
include_once '../Views/Subject/SubjectEditView.php';
include_once '../Views/Subject/SubjectSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$subjectDAO = new SubjectDAO();
$degreeDAO = new DegreeDAO();
$departmentDAO = new DepartmentDAO();
$teacherDAO = new TeacherDAO();

//Data required
$degreeData = $degreeDAO->showAll();
$departmentData = $departmentDAO->showAll();
$teacherData = $teacherDAO->showAll();

$subjectPrimaryKey = "id";
$value = $_REQUEST[$subjectPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Subject", "ADD")) {
            if (!isset($_POST["submit"])) {
                new SubjectAddView($degreeData, $departmentData, $teacherData);
            } else {
                try {
                    $subject = new Subject();
                    $subject->setCode($_POST["code"]);
                    $subject->setContent($_POST["content"]);
                    $subject->setType($_POST["type"]);
                    $subject->setDepartment($departmentDAO->show("id", $_POST["department_id"]));
                    $subject->setArea($_POST["area"]);
                    $subject->setCourse($_POST["course"]);
                    $subject->setQuarter($_POST["quarter"]);
                    $subject->setCredits($_POST["credits"]);
                    $subject->setNewRegistration($_POST["new_registration"]);
                    $subject->setRepeaters($_POST["repeaters"]);
                    $subject->setEffectiveStudents($_POST["effective_students"]);
                    $subject->setEnrolledHours($_POST["enrolled_hours"]);
                    $subject->setTaughtHours($_POST["taught_hours"]);
                    $subject->setHours($_POST["hours"]);
                    $subject->setStudents($_POST["students"]);
                    $subject->setDegree($degreeDAO->show("id", $_POST["degree_id"]));
                    $subject->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    $subjectDAO->add($subject);
                    goToShowAllAndShowSuccess("Asignatura añadida correctamente.");
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
        if (HavePermission("Subject", "DELETE")) {
            $subject = $subjectDAO->show($subjectPrimaryKey, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $subjectDAO->delete($subjectPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Asignatura eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $subjectDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar asignatura", "¿Está seguro de que desea eliminar " .
                        "la asignatura %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/SubjectController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Subject", "SHOWCURRENT")) {
            try {
                $subjectData = $subjectDAO->show($subjectPrimaryKey, $value);
                new SubjectShowView($subjectData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.");
        }
        break;
    case "edit":
        if (HavePermission("Subject", "EDIT")) {
            try {
                $subject = $subjectDAO->show($subjectPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new SubjectEditView($subject, $degreeData, $departmentData, $teacherData);
                } else {
                    $subject->setId($value);
                    $subject->setCode($_POST["code"]);
                    $subject->setContent($_POST["content"]);
                    $subject->setType($_POST["type"]);
                    $subject->setDepartment($departmentDAO->show("id", $_POST["department_id"]));
                    $subject->setArea($_POST["area"]);
                    $subject->setCourse($_POST["course"]);
                    $subject->setQuarter($_POST["quarter"]);
                    $subject->setCredits($_POST["credits"]);
                    $subject->setNewRegistration($_POST["new_registration"]);
                    $subject->setRepeaters($_POST["repeaters"]);
                    $subject->setEffectiveStudents($_POST["effective_students"]);
                    $subject->setEnrolledHours($_POST["enrolled_hours"]);
                    $subject->setTaughtHours($_POST["taught_hours"]);
                    $subject->setHours($_POST["hours"]);
                    $subject->setStudents($_POST["students"]);
                    $subject->setDegree($degreeDAO->show("id", $_POST["degree_id"]));
                    $subject->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    $subjectDAO->edit($subject);
                    goToShowAllAndShowSuccess("Asignatura editada correctamente.");
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
    case "search":
        if (HavePermission("Subject", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new SubjectSearchView($degreeData, $departmentData, $teacherData);
            } else {
                try {
                    $subject = new Subject();
                    if(!empty($_POST["code"])) {
                        $subject->setCode($_POST["content"]);
                    }
                    if(!empty($_POST["content"])) {
                        $subject->setContent($_POST["content"]);
                    }
                    if(!empty($_POST["type"])) {
                        $subject->setType($_POST["type"]);
                    }
                    if(!empty($_POST["department_id"])) {
                        $subject->setDepartment($departmentDAO->show("id", $_POST["department_id"]));
                    }
                    if(!empty($_POST["area"])) {
                        $subject->setArea($_POST["area"]);
                    }
                    if(!empty($_POST["course"])) {
                        $subject->setCourse($_POST["course"]);
                    }
                    if(!empty($_POST["quarter"])) {
                        $subject->setQuarter($_POST["quarter"]);
                    }
                    if(!empty($_POST["credits"])) {
                        $subject->setCredits($_POST["credits"]);
                    }
                    if(!empty($_POST["new_registration"])) {
                        $subject->setNewRegistration($_POST["new_registration"]);
                    }
                    if(!empty($_POST["repeaters"])) {
                        $subject->setRepeaters($_POST["repeaters"]);
                    }
                    if(!empty($_POST["effective_students"])) {
                        $subject->setEffectiveStudents($_POST["effective_students"]);
                    }
                    if(!empty($_POST["enrolled_hours"])) {
                        $subject->setEnrolledHours($_POST["enrolled_hours"]);
                    }
                    if(!empty($_POST["taught_hours"])) {
                        $subject->setTaughtHours($_POST["taught_hours"]);
                    }
                    if(!empty($_POST["hours"])) {
                        $subject->setHours($_POST["hours"]);
                    }
                    if(!empty($_POST["students"])) {
                        $subject->setStudents($_POST["students"]);
                    }
                    if(!empty($_POST["degree_id"])) {
                        $subject->setDegree($degreeDAO->show("id", $_POST["degree_id"]));
                    }
                    if(!empty($_POST["teacher_id"])) {
                        $subject->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    }
                    showAllSearch($subject);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.");
        }
        break;
    default:
        showAll();
        break;
}

function showAll() {
    showAllSearch(NULL);
}

function showAllSearch($search) {
    if (HavePermission("Subject", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalSubjects = $GLOBALS["subjectDAO"]->countTotalSubjects($toSearch);
            $subjectsData = $GLOBALS["subjectDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new SubjectShowAllView($subjectsData, $itemsPerPage, $currentPage, $totalSubjects, $toSearch);
        } catch (DAOException $e) {
            new SubjectShowAllView(array());
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