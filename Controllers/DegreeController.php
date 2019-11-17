<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Center/CenterDAO.php';
include_once '../Models/Degree/DegreeDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Degree/DegreeShowAllView.php';
include_once '../Views/Degree/DegreeAddView.php';
include_once '../Views/Degree/DegreeShowView.php';
include_once '../Views/Degree/DegreeEditView.php';
include_once '../Views/Degree/DegreeSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$centerDAO = new CenterDAO();
$degreeDAO = new DegreeDAO();
$userDAO = new UserDAO();

//Data required
$centerData = $centerDAO->showAll();
$userData = $userDAO->showAll();

$degreePrimaryKey = "id";
$value = $_REQUEST[$degreePrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("Degree", "ADD")) {
            if (!isset($_POST["submit"])) {
                new DegreeAddView($centerData, $userData);
            } else {
                try {
                    $degree = new Degree();
                    $degree->setName($_POST["name"]);
                    $degree->setCenter($centerDAO->show("id", $_POST["center_id"]));
                    $degree->setCapacity($_POST["capacity"]);
                    $degree->setDescription($_POST["description"]);
                    $degree->setCredits($_POST["credits"]);
                    $degree->setUser($userDAO->show("login", $_POST["user_id"]));
                    $degreeDAO->add($degree);
                    goToShowAllAndShowSuccess("Espacio añadido correctamente.");
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
        if (HavePermission("Degree", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $degreeDAO->delete($degreePrimaryKey, $value);
                    goToShowAllAndShowSuccess("Titulación eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $degreeDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar titulación", "¿Está seguro de que desea eliminar " .
                        "la titulación %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/DegreeController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Degree", "SHOWCURRENT")) {
            try {
                $degreeData = $degreeDAO->show($degreePrimaryKey, $value);
                new DegreeShowView($degreeData);
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
        if (HavePermission("Degree", "EDIT")) {
            try {
                $degree = $degreeDAO->show($degreePrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new DegreeEditView($degree, $centerData, $userData);
                } else {
                    $degree->setName($_POST["name"]);
                    $degree->setCenter($centerDAO->show("id", $_POST["center_id"]));
                    $degree->setCapacity($_POST["capacity"]);
                    $degree->setDescription($_POST["description"]);
                    $degree->setCredits($_POST["credits"]);
                    $degree->setUser($userDAO->show("login", $_POST["user_id"]));
                    $degreeDAO->edit($degree);
                    goToShowAllAndShowSuccess("Espacio editado correctamente.");
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
        if (HavePermission("Degree", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new DegreeSearchView($centerData);
            } else {
                try {
                    $degree = new Degree();
                    if (!empty($_POST["name"])) {
                        $degree->setName($_POST["name"]);
                    }
                    if (!empty($_POST["capacity"])) {
                        $degree->setCapacity($_POST["capacity"]);
                    }
                    if (!empty($_POST["center_id"])) {
                        $degree->setCenter($centerDAO->show("id", $_POST["center_id"]));
                    }
                    showAllSearch($degree);
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

function showAll()
{
    showAllSearch(NULL);
}

function showAllSearch($search)
{
    if (HavePermission("Degree", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $totalDegrees = $GLOBALS["degreeDAO"]->countTotalDegrees($toSearch);
            $degreesData = $GLOBALS["degreeDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new DegreeShowAllView($degreesData, $itemsPerPage, $currentPage, $totalDegrees, $toSearch);
        } catch (DAOException $e) {
            new DegreeShowAllView(array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message)
{
    showAll();
    errorMessage($message);
}

function goToShowAllAndShowSuccess($message)
{
    showAll();
    successMessage($message);
}