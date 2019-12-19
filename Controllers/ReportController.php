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
include_once '../Functions/GetReportResults.php';


$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "search":
        //TODO: Cambiar el permiso a User
        if (HavePermission("User", "SEARCH")) {
            if (!isset($_POST["entity"])) {
                new ReportSearchView();
            } else {
                switch($_POST["entity"]) {
                    case "center":
                        if (!isset($_POST["submit"])) {
                            new ReportCenterSearchView();
                        } else {
                            try {
                                $sql = "SELECT CENTER.* FROM CENTER";
                                $universityId = $_POST["universityId"];
                                if($universityId != NULL){
                                    $sql .= ", UNIVERSITY WHERE UNIVERSITY.id =" . $universityId.";";
                                }
                                echo $sql;
                                $reportDump = returnData($sql);
                                echo $reportDump;
                                new ReportCenterShowAllView($reportDump);
                                goToShowAllAndShowSuccess("Departamento añadido correctamente.");
                            } catch (DAOException $e) {
                                goToShowAllAndShowError($e->getMessage());
                            } catch (ValidationException $ve) {
                                goToShowAllAndShowError($ve->getMessage());
                            }
                        }
                        break;
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
    new ReportSearchView();
}

