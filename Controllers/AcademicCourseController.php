<?php

session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/HavePermission.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/AcademicCourse/AcademicCourseDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/AcademicCourse/AcademicCourseShowAllView.php';
include_once '../Views/AcademicCourse/AcademicCourseAddView.php';
include_once '../Views/AcademicCourse/AcademicCourseShowView.php';
include_once '../Views/AcademicCourse/AcademicCourseEditView.php';
include_once '../Views/AcademicCourse/AcademicCourseSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAO
$academicCourseDAO = new AcademicCourseDAO();

$academicCoursePrimaryKey = "id";
$value = $_REQUEST[$academicCoursePrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($action) {
    case "add":
        if (HavePermission("AcademicCourse", "ADD")) {
            if (!isset($_POST["submit"])) {
                new AcademicCourseAddView();
            } else {
                try {
                    $academicCourse = new AcademicCourse(NULL,
                        NULL, $_POST["start_year"], $_POST["end_year"]);
                    $academicCourseDAO->add($academicCourse);
                    goToShowAllAndShowSuccess("Curso académico añadido correctamente.");
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
        if (HavePermission("AcademicCourse", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $academicCourseDAO->delete($academicCoursePrimaryKey, $value);
                    goToShowAllAndShowSuccess("Curso académico eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $academicCourse = $academicCourseDAO->show($academicCoursePrimaryKey, $value);
                    $academicCourseDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar curso académico", "¿Está seguro de que desea eliminar" .
                    " el curso académico %" . $academicCourse->getAcademicCourseAbbr() .
                    "%? Esta acción es permanente y no se puede recuperar.",
                    "../Controllers/AcademicCourseController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("AcademicCourse", "SHOWCURRENT")) {
            try {
                $academicCourseData = $academicCourseDAO->show($academicCoursePrimaryKey, $value);
                new AcademicCourseShowView($academicCourseData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso visualizar la entidad.");
        }
        break;
    case "edit":
        if (HavePermission("AcademicCourse", "EDIT")) {
            try {
                $academicCourse = $academicCourseDAO->show($academicCoursePrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new AcademicCourseEditView($academicCourse);
                } else {
                    $academicCourse->setId($value);
                    $academicCourse->isCorrectAcademicCourse($_POST["start_year"], $_POST["end_year"]);
                    $academicCourse->setStartYear($_POST["start_year"]);
                    $academicCourse->setEndYear($_POST["end_year"]);
                    $academicCourse->setAcademicCourseAbbr($academicCourse->formatAbbr($_POST["start_year"], $_POST["end_year"]));
                    $academicCourseDAO->edit($academicCourse);
                    goToShowAllAndShowSuccess("Curso académico editado correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    case "search":
        if(HavePermission("AcademicCourse", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new AcademicCourseSearchView();
            } else {
                try {
                    $academicCourse = new AcademicCourse();
                    if (!empty($_POST["start_year"]) && !empty($_POST["end_year"])) {
                        $academicCourse->isCorrectAcademicCourse($_POST["start_year"], $_POST["end_year"]);
                    }
                    if (!empty($_POST["start_year"])) {
                        $academicCourse->setStartYear($_POST["start_year"]);
                    }
                    if (!empty($_POST["end_year"])) {
                        $academicCourse->setEndYear($_POST["end_year"]);
                    }
                    if (!empty($_POST["academic_course_abbr"])) {
                        $academicCourse->setAcademicCourseAbbr($_POST["academic_course_abbr"]);
                    }
                    showAllSearch($academicCourse);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else{
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
    if (HavePermission("AcademicCourse", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalAcademicCourses = $GLOBALS["academicCourseDAO"]->countTotalAcademicCourses($toSearch);
            $academicCoursesData = $GLOBALS["academicCourseDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new AcademicCourseShowAllView($academicCoursesData, $itemsPerPage, $currentPage, $totalAcademicCourses, $toSearch);
        } catch (DAOException $e) {
            new AcademicCourseShowAllView(array());
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