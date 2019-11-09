<?php

session_start();
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}
include '../Models/AcademicCourse/AcademicCourseDAO.php';
include '../Models/Common/MessageType.php';
include '../Models/Common/DAOException.php';
include '../Views/Common/Head.php';
include '../Views/Common/DefaultView.php';
include '../Views/AcademicCourse/AcademicCourseShowAllView.php';
include '../Views/AcademicCourse/AcademicCourseAddView.php';
include '../Views/AcademicCourse/AcademicCourseShowView.php';
include '../Views/AcademicCourse/AcademicCourseEditView.php';
include '../Functions/ShowToast.php';
include '../Functions/OpenDeletionModal.php';
include '../Functions/Redirect.php';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($action) {
    case "add":
        if (!isset($_POST["submit"])){
            new AcademicCourseAddView();
        }
        else {
            try {
                $academicCourse = new AcademicCourse();
                //$academicCourse->setIdAcademicCourse($_POST["idAcademicCourse"]);
                $academicCourse->setStartYear($_POST["start_year"]);
                $academicCourse->setEndYear($_POST["end_year"]);
                $academicCourseDAO = new AcademicCourseDAO();
                $academicCourseDAO->add($academicCourse);
                $message = MessageType::SUCCESS;
                showAll();
                showToast($message, "Año académico añadido correctamente.");
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        }
        break;

    case "delete":
        if (isset($_REQUEST["confirm"])) {
            try {
                $key = "IdAcademicCourse";
                $value = $_REQUEST[$key];
                $academicCourseDAO = new AcademicCourseDAO();
                $response = $academicCourseDAO->delete($key, $value);
                $message = MessageType::SUCCESS;
                showAll();
                showToast($message, "Año académico eliminado correctamente.");
            } catch (DAOException $e) {
                $message = MessageType::ERROR;
                showAll();
                showToast($message, $e->getMessage());
            }
        } else {
            showAll();
            $key = "IdAcademicCourse";
            $value = $_REQUEST[$key];
            openDeletionModal("Eliminar año académico " . $value, "¿Está seguro de que desea eliminar " .
                "el año académico <b>" . $value . "</b>? Esta acción es permanente y no se puede recuperar.",
            "../Controllers/AcademicCourseController.php?action=delete&login=" . $value . "&confirm=true");
        }
        break;

    case "show":
        try {
            $key = "IdAcademicCourse";
            $value = $_REQUEST[$key];
            $academicCourseDAO = new AcademicCourseDAO();
            $academicCourseData = $academicCourseDAO->show($key, $value);
            new AcademicCourseShowView($academicCourseData);
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            showAll();
            showToast($message, $e->getMessage());
        }
        break;
    case "edit":
        $key = "IdAcademicCourse";
        $value = $_REQUEST[$key];
        $academicCourseDAO = new AcademicCourseDAO();
        try {
            $academicCourse = $academicCourseDAO->show($key, $value);
            if (!isset($_POST["submit"])){
                new AcademicCourseEditView($academicCourse);
            } else {
                try {
                    //$academicCourse->setIdAcademicCourse($_POST["IdAcademicCourse"]);
                    $academicCourse->setStartYear($_POST["start_year"]);
                    $academicCourse->setEndYear($_POST["end_year"]);

                    $academicCourseDAO = new AcademicCourseDAO();
                    $response = $academicCourseDAO->edit($academicCourse);
                    $message = MessageType::SUCCESS;
                    showAll();
                    showToast($message, "Año académico editado correctamente.");
                } catch (DAOException $e) {
                    $message = MessageType::ERROR;
                    showAll();
                    showToast($message, $e->getMessage());
                }
            }
        } catch (DAOException $e) {
            $message = MessageType::ERROR;
            showAll();
            showToast($message, $e->getMessage());
        }
        break;
    default:
        showAll();
        break;
}

function showAll() {
    try {
        $academicCourseDAO = new AcademicCourseDAO();
        $academicCoursesData = $academicCourseDAO->showAll();
        new AcademicCourseShowAllView($academicCoursesData);
    } catch (DAOException $e) {
        $message = MessageType::ERROR;
        new AcademicCourseShowAllView(array());
        showToast($message, $e->getMessage());
    }
}
