<?php

session_start();
include_once '../Functions/Authentication.php';
include_once '../Functions/HavePermission.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/AcademicCourse/AcademicCourseDAO.php';
include_once '../Models/Common/MessageType.php';
include_once '../Models/Common/DAOException.php';
include_once '../Models/Common/ValidationException.php';
include_once'../Views/Common/Head.php';
include_once'../Views/Common/DefaultView.php';
include_once'../Views/AcademicCourse/AcademicCourseShowAllView.php';
include_once'../Views/AcademicCourse/AcademicCourseAddView.php';
include_once'../Views/AcademicCourse/AcademicCourseShowView.php';
include_once'../Views/AcademicCourse/AcademicCourseEditView.php';
include_once'../Views/AcademicCourse/AcademicCourseSearchView.php';
include_once'../Functions/ShowToast.php';
include_once'../Functions/OpenDeletionModal.php';
include_once'../Functions/Redirect.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($action) {
    case "add":
        if(HavePermission("AcademicCourse", "ADD")) {
            if (!isset($_POST["submit"])) {
                new AcademicCourseAddView();
            } else {
                try {
                    $academicCourse = new AcademicCourse(NULL,
                        NULL, $_POST["start_year"], $_POST["end_year"]);
                    $academicCourseDAO = new AcademicCourseDAO();
                    $academicCourseDAO->add($academicCourse);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Curso académico añadido correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                } catch (ValidationException $ve) {
                    $message = MessageType::ERROR;
                    new AcademicCourseAddView();
                    showToast($message, $ve->getMessage());
                }
            }
        } else{
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "delete":
        if(HavePermission("AcademicCourse", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $key = "id_academic_course";
                    $value = $_REQUEST[$key];
                    $academicCourseDAO = new AcademicCourseDAO();
                    $response = $academicCourseDAO->delete($key, $value);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Curso académico eliminado correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                } catch (ValidationException $ve) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $ve->getMessage());
                }
            } else {
                showAll();
                $key = "id_academic_course";
                $value = $_REQUEST[$key];
                try {
                    $academicCourseDAO = new AcademicCourseDAO();
                    $academicCourse = $academicCourseDAO->show($key, $value);
                    openDeletionModal("Eliminar año académico " . $academicCourse->getAcademicCourseAbbr(),
                        "¿Está seguro de que desea eliminar el año académico <b>" . $academicCourse->getAcademicCourseAbbr() .
                        "</b>? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/AcademicCourseController.php?action=delete&id_academic_course=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                } catch (ValidationException $ve) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $ve->getMessage());
                }
            }
        } else{
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "show":
        if(HavePermission("AcademicCourse", "SHOWCURRENT")) {
            try {
                $key = "id_academic_course";
                $value = $_REQUEST[$key];
                $academicCourseDAO = new AcademicCourseDAO();
                $academicCourseData = $academicCourseDAO->show($key, $value);
                new AcademicCourseShowView($academicCourseData);
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            } catch (ValidationException $ve) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $ve->getMessage());
            }
        } else{
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "edit":
        if(HavePermission("AcademicCourse", "EDIT")) {
            $key = "id_academic_course";
            $value = $_REQUEST[$key];
            $academicCourseDAO = new AcademicCourseDAO();
            try {
                $academicCourse = $academicCourseDAO->show($key, $value);
                if (!isset($_POST["submit"])) {
                    new AcademicCourseEditView($academicCourse);
                } else {
                    try {
                        $academicCourse->isCorrectAcademicCourse($_POST["start_year"], $_POST["end_year"]);
                        $academicCourse->setStartYear($_POST["start_year"]);
                        $academicCourse->setEndYear($_POST["end_year"]);
                        $academicCourse->setAcademicCourseAbbr($academicCourse->formatAbbr($_POST["start_year"], $_POST["end_year"]));
                        $academicCourseDAO = new AcademicCourseDAO();
                        $response = $academicCourseDAO->edit($academicCourse);
                        $message = MessageType::SUCCESS;
                        showAll();
                        showToast($message, "Curso académico editado correctamente.");
                    } catch (DAOException $e) {
                        $message = MessageType::ERROR;
                        showAll();
                        showToast($message, $e->getMessage());
                    } catch (ValidationException $ve) {
                        $message = MessageType::ERROR;
                        new AcademicCourseEditView($academicCourse);
                        showToast($message, $ve->getMessage());
                    }
                }
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            } catch (ValidationException $ve) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $ve->getMessage());
            }
        } else{
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
        }
        break;
    case "search":
        if(HavePermission("Permission", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new AcademicCourseSearchView();
            } else {
                try {
                    $academicCourse = new AcademicCourse();
                    if (!empty($_POST["start_year"]) && !empty($_POST["start_year"])) {
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
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                } catch (ValidationException $ve) {
                    $message = MessageType::ERROR;
                    new AcademicCourseSearchView();
                    showToast($message, $ve->getMessage());
                }
            }
        } else{
            $message = MessageType::ERROR;
            showToast($message, "No tienes permiso para acceder");
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
    if(HavePermission("AcademicCourse", "SHOWALL")) {
        try {
            $academicCourseDAO = new AcademicCourseDAO();
            if (!empty($_REQUEST['currentPage'])) {
                $currentPage = $_REQUEST['currentPage'];
            } else {
                $currentPage = 1;
            }
            if (!empty($_REQUEST['itemsPerPage'])) {
                $itemsPerPage = $_REQUEST['itemsPerPage'];
            } else {
                $itemsPerPage = 10;
            }
            $searchRequested = $_REQUEST['search'];
            if (!empty($searchRequested)) {
                $toSearch = $searchRequested;
            } elseif (!is_null($search)) {
                $toSearch = $search;
            } else {
                $toSearch = NULL;
            }
            $totalAcademicCourses = $academicCourseDAO->countTotalAcademicCourses($toSearch);
            $academicCoursesData = $academicCourseDAO->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new AcademicCourseShowAllView($academicCoursesData, $itemsPerPage, $currentPage, $totalAcademicCourses, $toSearch);
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            new AcademicCourseShowAllView(array());
            showToast($message, $e->getMessage());
        }
    } else{
        $message = MessageType::ERROR;
        showToast($message, "No tienes permiso para acceder");
    }
}