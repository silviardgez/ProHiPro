<?php
session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Models/University/UniversityDAO.php';
include_once '../Models/Center/CenterDAO.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Report/ReportShowAllView.php';
include_once '../Views/Report/ReportSearchView.php';
include_once '../Views/Report/ReportCenterSearchView.php';
include_once '../Views/Report/ReportCenterShowAllView.php';
include_once '../Views/Report/ReportDegreeSearchView.php';
include_once '../Views/Report/ReportDegreeShowAllView.php';
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


//DAOS
$universityDAO = new UniversityDAO();
$centerDAO = new CenterDAO();

//Data required
$universityData = $universityDAO->showAll();
$centerData = $centerDAO->showAll();

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "search":
        if (!isset($_POST["entity"])) {
            new ReportSearchView();
        } else {
            switch($_POST["entity"]) {
                case "center":
                    if (!isset($_POST["university"])) {
                        new ReportCenterSearchView($universityData);
                    } else {
                        try {
                            $sql = "SELECT CENTER.* FROM CENTER";
                            $universityId = $_POST["university"];
                            if($universityId != NULL){
                                $sql = $sql . ", UNIVERSITY WHERE UNIVERSITY.id =" . $universityId . ";";
                            }
                            $reportDump = returnData($sql);
                            $centers = $centerDAO->getCentersFromDB($reportDump);
                            new ReportCenterShowAllView($centers);
                            goToShowAllAndShowSuccess("Departamento añadido correctamente.");
                        } catch (DAOException $e) {
                            goToShowAllAndShowError($e->getMessage());
                        } catch (ValidationException $ve) {
                            goToShowAllAndShowError($ve->getMessage());
                        }
                    }
                    break;

                case "degree":
                    if (!isset($_POST["university"])) {
                        new ReportDegreeSearchView($universityData, $centerData);
                    } else {
                        try {
                            $sql = "SELECT CENTER.* FROM CENTER";
                            $universityId = $_POST["university"];
                            if($universityId != NULL){
                                $sql = $sql . ", UNIVERSITY WHERE UNIVERSITY.id =" . $universityId . ";";
                            }
                            $reportDump = returnData($sql);
                            $centers = $centerDAO->getCentersFromDB($reportDump);
                            new ReportDegreeShowAllView($centers);
                            goToShowAllAndShowSuccess("Departamento añadido correctamente.");
                        } catch (DAOException $e) {
                            goToShowAllAndShowError($e->getMessage());
                        } catch (ValidationException $ve) {
                            goToShowAllAndShowError($ve->getMessage());
                        }
                    }
                    break;

                default:
                    showAll();
                    break;
            }
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

