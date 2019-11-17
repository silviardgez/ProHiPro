<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/University/UniversityDAO.php';
include_once '../Models/AcademicCourse/AcademicCourseDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/University/UniversityShowAllView.php';
include_once '../Views/University/UniversityAddView.php';
include_once '../Views/University/UniversityShowView.php';
include_once '../Views/University/UniversityEditView.php';
include_once '../Views/University/UniversitySearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/IsUniversityOwner.php';
include_once '../Functions/IsAdmin.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$universityDAO = new UniversityDAO();
$academicCourseDAO = new AcademicCourseDAO();
$userDAO = new UserDAO();

//Data required
$academicCourseData = $academicCourseDAO->showAll();
$userData = $userDAO->showAll();

$universityPrimaryKey = "id";
$value = $_REQUEST[$universityPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("University", "ADD")) {
            if (!isset($_POST["submit"])) {
                new UniversityAddView($academicCourseData, $userData);
            } else {
                try {
                    $university = new University();
                    $university->setAcademicCourse($academicCourseDAO->show("id", $_POST["academic_course_id"]));
                    $university->setUser($userDAO->show("login", $_POST["user_id"]));
                    $university->setName($_POST["name"]);
                    $universityDAO->add($university);
                    goToShowAllAndShowSuccess("Universidad añadida correctamente.");
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
        if (HavePermission("University", "DELETE")) {
            $university = $universityDAO->show($universityPrimaryKey, $value);
            if(IsAdmin() || $university == IsUniversityOwner()) {
                if (isset($_REQUEST["confirm"])) {
                    try {
                        $universityDAO->delete($universityPrimaryKey, $value);
                        goToShowAllAndShowSuccess("Universidad eliminada correctamente.");
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage());
                    }
                } else {
                    try {
                        $universityDAO->checkDependencies($value);
                        showAll();
                        openDeletionModal("Eliminar universidad", "¿Está seguro de que desea eliminar " .
                            "la universidad %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                            "../Controllers/UniversityController.php?action=delete&id=" . $value . "&confirm=true");
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage());
                    }
                }
            }else {
                goToShowAllAndShowError("No tienes permiso para eliminar.");
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("University", "SHOWCURRENT")) {
            try {
                $universityData = $universityDAO->show($universityPrimaryKey, $value);
                new UniversityShowView($universityData);
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
        if (HavePermission("University", "EDIT")) {
            try {
                $university = $universityDAO->show($universityPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    if(IsAdmin() || $university == IsUniversityOwner()){
                        new UniversityEditView($university, $academicCourseData,$userData);
                    } else{
                        goToShowAllAndShowError("No tienes permiso para editar.");
                    }
                } else {
                    $university->setId($value);
                    $university->setAcademicCourse($academicCourseDAO->show("id", $_POST["academic_course_id"]));
                    $university->setUser($userDAO->show("login", $_POST["user_id"]));
                    $university->setName($_POST["name"]);
                    $universityDAO->edit($university);
                    goToShowAllAndShowSuccess("Universidad editada correctamente.");
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
        if (HavePermission("University", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new UniversitySearchView($academicCourseData, $userData);
            } else {
                try {
                    $university = new University();
                    if(!empty($_POST["academic_course_id"])) {
                        $university->setAcademicCourse($academicCourseDAO->show("id", $_POST["academic_course_id"]));
                    }
                    if(!empty($_POST["name"])) {
                        $university->setName($_POST["name"]);
                    }
                    showAllSearch($university);
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
    if (HavePermission("University", "SHOWALL")) {
        try {
            $searching=False;
            if (!empty($search)) {
                $searching = True;
            }
            if (!IsAdmin()) {
                $university = IsUniversityOwner();
                if(!empty($university)){
                    $search=$university;
                }
                else{
                    new UniversityShowAllView(array());
                }
                $searching = False;
            }
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalUniversities = $GLOBALS["universityDAO"]->countTotalUniversities($toSearch);
            $universitiesData = $GLOBALS["universityDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new UniversityShowAllView($universitiesData, $itemsPerPage, $currentPage, $totalUniversities, $toSearch, $searching);
        } catch (DAOException $e) {
            new UniversityShowAllView(array());
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