<?php
session_start();
include_once '../Functions/Authentication.php';
if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/Tutorial/TutorialDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Tutorial/TutorialShowAllView.php';
include_once '../Views/Tutorial/TutorialAddView.php';
include_once '../Views/Tutorial/TutorialShowView.php';
include_once '../Views/Tutorial/TutorialEditView.php';
include_once '../Views/Tutorial/TutorialSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/IsAdmin.php';
include_once '../Functions/IsTeacher.php';
include_once '../Functions/IsTutorialOwner.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';
//DAOS
$tutorialDAO = new TutorialDAO();
$teacherDAO = new TeacherDAO();
$spaceDAO = new SpaceDAO();
//Data required
$teacherData = $teacherDAO->showAll();
$spaceData = $spaceDAO->showAll();
$tutorialPrimaryKey = "id";
$value = $_REQUEST[$tutorialPrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Tutorial", "ADD") && (IsTeacher() or IsAdmin())) {
            if (!isset($_POST["submit"])) {
                if(!IsAdmin()){
                    $teachers=array();
                    foreach ($teacherData as $teach){
                        if($teach->getUser()->getLogin() == $_SESSION['login']){
                            array_push($teachers,$teach);
                        }
                    }
                    $teacherData=$teachers;
                }
                new TutorialAddView($teacherData, $spaceData);
            } else {
                try {
                    $tutorial = new Tutorial();
                    $tutorial->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    $tutorial->setSpace($spaceDAO->show("id", $_POST["space_id"]));
                    $tutorial->setTotalHours($_POST["total_hours"]);
                    $tutorialDAO->add($tutorial);
                    goToShowAllAndShowSuccess("Tutoría añadida correctamente.");
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
        if (HavePermission("Tutorial", "DELETE")&& (IsTeacher() or IsAdmin())) {
            $tutorial = $tutorialDAO->show($tutorialPrimaryKey, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $tutorialDAO->delete($tutorialPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Tutoría eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $tutorialDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar tutoría", "¿Está seguro de que desea eliminar " .
                        "la tutoría %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/TutorialController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Tutorial", "SHOWCURRENT")) {
            try {
                $tutorialData = $tutorialDAO->show($tutorialPrimaryKey, $value);
                new TutorialShowView($tutorialData);
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
        if (HavePermission("Tutorial", "EDIT")&& (IsTeacher() or IsAdmin())) {
            try {
                $tutorial = $tutorialDAO->show($tutorialPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    if(!IsAdmin()){
                        $teachers=array();
                        foreach ($teacherData as $teach){
                            if($teach->getUser()->getLogin() == $_SESSION['login']){
                                array_push($teachers,$teach);
                            }
                        }
                        $teacherData=$teachers;
                    }
                    new TutorialEditView($tutorial, $teacherData, $spaceData);
                } else {
                    $tutorial->setId($value);
                    $tutorial->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    $tutorial->setSpace($spaceDAO->show("id", $_POST["space_id"]));
                    $tutorial->setTotalHours($_POST["total_hours"]);
                    $tutorialDAO->edit($tutorial);
                    goToShowAllAndShowSuccess("Tutoría editada correctamente.");
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
        if (HavePermission("Tutorial", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new TutorialSearchView($teacherData, $spaceData);
            } else {
                try {
                    $tutorial = new Tutorial();
                    if(!empty($_POST["total_hours"])) {
                        $tutorial->setTotalHours($_POST["total_hours"]);
                    }
                    if(!empty($_POST["teacher_id"])) {
                        $tutorial->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    }
                    if(!empty($_POST["space_id"])) {
                        $tutorial->setSpace($spaceDAO->show("id", $_POST["space_id"]));
                    }
                    showAllSearch($tutorial);
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
    if (HavePermission("Tutorial", "SHOWALL")) {
        try {
            $break = false;
            $searching=false;
            if(!empty($search)){
                $searching=true;
            }
            if(!IsTeacher() && !IsAdmin()){
                new TutorialShowAllView(array());
                errorMessage("No es profesor.");
                $break=true;
            }
            if(!IsAdmin() and !$break){
                $test = IsTutorialOwner();
                if(empty($test)){
                    $break=true;
                    new TutorialShowAllView(array());
                }else{
                    $toret=$test;
                    $searching=false;
                }
            }
            if(!$break){
                $currentPage = getCurrentPage();
                $itemsPerPage = getItemsPerPage();
                $totalTutorials=0;
                if(!empty($toret) && count($toret)==1){
                    $search=$toret[0];
                    $toSearch = getToSearch($search);
                    $totalTutorials = $GLOBALS["tutorialDAO"]->countTotalTutorials($toSearch);
                    $tutorialsData = $GLOBALS["tutorialDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
                    new TutorialShowAllView($tutorialsData, $itemsPerPage, $currentPage, $totalTutorials, $toSearch, $searching);
                }elseif (count($toret)>1){
                    $tutorialsData=array();
                    foreach ($toret as $tut){
                        $search=$tut;
                        $toSearch = getToSearch($search);
                        $totalTutorials += $GLOBALS["tutorialDAO"]->countTotalTutorials($toSearch);
                        $data = $GLOBALS["tutorialDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
                        foreach ($data as $dat){
                            array_push($tutorialsData,$dat);
                        }
                    }
                    new TutorialShowAllView($tutorialsData, $itemsPerPage, $currentPage, $totalTutorials, $toSearch, $searching);
                }else{
                    $toSearch = getToSearch($search);
                    $totalTutorials = $GLOBALS["tutorialDAO"]->countTotalTutorials($toSearch);
                    $tutorialsData = $GLOBALS["tutorialDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
                    new TutorialShowAllView($tutorialsData, $itemsPerPage, $currentPage, $totalTutorials, $toSearch, $searching);
                }
            }
        } catch (DAOException $e) {
            new TutorialShowAllView(array());
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