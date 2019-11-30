<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Group/GroupDAO.php';
include_once '../Models/Subject/SubjectDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Group/GroupShowAllView.php';
include_once '../Views/Group/GroupAddView.php';
include_once '../Views/Group/GroupShowView.php';
include_once '../Views/Group/GroupEditView.php';
include_once '../Views/Group/GroupSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$groupDAO = new GroupDAO();
$subjectDAO = new SubjectDAO();

//Data required
$subjectData = $subjectDAO->showAll();

$groupPrimaryKey = "id";
$value = $_REQUEST[$groupPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("SubjectGroup", "ADD")) {
            if (!isset($_POST["submit"])) {
                new GroupAddView($subjectData);
            } else {
                try {
                    $group = new SubjectGroup();
                    $group->setSubject($subjectDAO->show("id", $_POST["subject_id"]));
                    $group->setName($_POST["name"]);
                    $group->setCapacity($_POST["capacity"]);
                    $groupDAO->add($group);
                    goToShowAllAndShowSuccess("Grupo añadido correctamente.");
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
        if (HavePermission("SubjectGroup", "DELETE")) {
            $group = $groupDAO->show($groupPrimaryKey, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $groupDAO->delete($groupPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Grupo eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $groupDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar grupo", "¿Está seguro de que desea eliminar " .
                        "el grupo %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/GroupController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("SubjectGroup", "SHOWCURRENT")) {
            try {
                $groupData = $groupDAO->show($groupPrimaryKey, $value);
                new GroupShowView($groupData);
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
        if (HavePermission("SubjectGroup", "EDIT")) {
            try {
                $group = $groupDAO->show($groupPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new GroupEditView($group, $subjectData);
                } else {
                    $group->setId($value);
                    $group->setSubject($subjectDAO->show("id", $_POST["subject_id"]));
                    $group->setName($_POST["name"]);
                    $group->setCapacity($_POST["capacity"]);
                    $groupDAO->edit($group);
                    goToShowAllAndShowSuccess("Grupo editado correctamente.");
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
        if (HavePermission("SubjectGroup", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new GroupSearchView($degreeData, $departmentData, $teacherData);
            } else {
                try {
                    $group = new SubjectGroup();
                    if(!empty($_POST["subject_id"])) {
                        $group->setSubject($subjectDAO->show("id", $_POST["subject_id"]));
                    }
                    if(!empty($_POST["name"])) {
                        $group->setContent($_POST["name"]);
                    }
                    if(!empty($_POST["capacity"])) {
                        $group->setType($_POST["capacity"]);
                    }
                    showAllSearch($group);
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
    if (HavePermission("SubjectGroup", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalGroups = $GLOBALS["groupDAO"]->countTotalGroups($toSearch);
            $groupsData = $GLOBALS["groupDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new GroupShowAllView($groupsData, $itemsPerPage, $currentPage, $totalGroups, $toSearch);
        } catch (DAOException $e) {
            new GroupShowAllView(array());
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