<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Teacher/TeacherShowAllView.php';
include_once '../Views/Teacher/TeacherAddView.php';
include_once '../Views/Teacher/TeacherShowView.php';
include_once '../Views/Teacher/TeacherEditView.php';
include_once '../Views/Teacher/TeacherSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$teacherDAO = new TeacherDAO();
$userDAO = new UserDAO();
$spaceDAO = new SpaceDAO();


//Data required
$userData = $userDAO->showAll();
$spaceData = $spaceDAO->showAllFreeOffices();

$teacherPrimaryKey = "id";
$value = $_REQUEST[$teacherPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Teacher", "ADD")) {
            if (!isset($_POST["submit"])) {
                new TeacherAddView($userData, $spaceData);
            } else {
                try {
                    $teacher = new Teacher();
                    if(!empty($_POST["space_id"])) {
                        $teacher->setSpace($spaceDAO->show("id", $_POST["space_id"]));
                    } else {
                        $teacher->setSpace(new Space());
                    }
                    $teacher->setUser($userDAO->show("login", $_POST["user_id"]));
                    $teacher->setDedication($_POST["dedication"]);
                    $teacherDAO->add($teacher);
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
        if (HavePermission("Teacher", "DELETE")) {
            $teacher = $teacherDAO->show($teacherPrimaryKey, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $teacherDAO->delete($teacherPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Profesor eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $teacherDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar profesor", "¿Está seguro de que desea eliminar " .
                        "el profesor %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/TeacherController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Teacher", "SHOWCURRENT")) {
            try {
                $teacherData = $teacherDAO->show($teacherPrimaryKey, $value);
                new TeacherShowView($teacherData);
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
        if (HavePermission("Teacher", "EDIT")) {
            try {
                $teacher = $teacherDAO->show($teacherPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new TeacherEditView($teacher, $userData, $spaceData);
                } else {
                    $teacher->setId($value);
                    if (!empty($_POST["space_id"])) {
                        $teacher->setSpace($spaceDAO->show("id", $_POST["space_id"]));
                    } else {
                        $teacher->setSpace(new Space());
                    }
                    $teacher->setUser($userDAO->show("login", $_POST["user_id"]));
                    $teacher->setDedication($_POST["dedication"]);
                    $teacherDAO->edit($teacher);
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
    case "search":
        if (HavePermission("Teacher", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new TeacherSearchView($userData, $spaceData);
            } else {
                try {
                    $teacher = new Teacher();
                    if(!empty($_POST["user_id"])) {
                        $teacher->setUser($userDAO->show("login", $_POST["user_id"]));
                    }
                    if(!empty($_POST["space_id"])) {
                        $teacher->setSpace($spaceDAO->show("id", $_POST["space_id"]));
                    }
                    if(!empty($_POST["dedication"])) {
                        $teacher->setDedication($_POST["dedication"]);
                    }
                    showAllSearch($teacher);
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
    if (HavePermission("Teacher", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalTeachers = $GLOBALS["teacherDAO"]->countTotalTeachers($toSearch);
            $teachersData = $GLOBALS["teacherDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new TeacherShowAllView($teachersData, $itemsPerPage, $currentPage, $totalTeachers, $toSearch);
        } catch (DAOException $e) {
            new TeacherShowAllView(array());
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