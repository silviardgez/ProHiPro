<?php
session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Report/ReportShowAllView.php';
include_once '../Views/Report/ReportSearchView.php';
include_once '../Views/User/UserShowAllView.php';
include_once '../Views/User/UserAddView.php';
include_once '../Views/User/UserShowView.php';
include_once '../Views/User/UserEditView.php';
include_once '../Views/User/UserSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAO
$userDAO = new UserDAO();

$userPrimaryKey = "login";
$value = $_REQUEST[$userPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "search":
        if (HavePermission("User", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new ReportSearchView();
            } else {
                try {
                    $user = new User();
                    if(!empty($_POST["login"])) {
                        $user->setLogin($_POST["login"]);
                    }
                    if(!empty($_POST["dni"])) {
                        $user->setDni($_POST["dni"]);
                    }
                    if(!empty($_POST["name"])) {
                        $user->setName($_POST["name"]);
                    }
                    if(!empty($_POST["surname"])) {
                        $user->setSurname($_POST["surname"]);
                    }
                    if(!empty($_POST["email"])) {
                        $user->setEmail($_POST["email"]);
                    }
                    if(!empty($_POST["address"])) {
                        $user->setAddress($_POST["address"]);
                    }
                    if(!empty($_POST["telephone"])) {
                        $user->setTelephone($_POST["telephone"]);
                    }
                    showAllSearch($user);
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

function showAllSearch($search) {
    if (HavePermission("User", "SHOWALL")) {
        try {
            $currentPage = getCurrentPage();
            $itemsPerPage = getItemsPerPage();
            $toSearch = getToSearch($search);
            $usersData = $GLOBALS["userDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            $totalUsers = $GLOBALS["userDAO"]->countTotalUsers($toSearch);
            new ReportShowAllView($usersData, $itemsPerPage, $currentPage, $totalUsers, $toSearch);
        } catch (DAOException $e) {
            new ReportShowAllView(array());
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


