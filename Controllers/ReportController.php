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
include_once '../Models/Degree/DegreeDAO.php';
include_once '../Models/Subject/SubjectDAO.php';
include_once '../Models/Department/DepartmentDAO.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Report/ReportShowAllView.php';
include_once '../Views/Report/ReportSearchView.php';
include_once '../Views/Report/ReportCenterSearchView.php';
include_once '../Views/Report/ReportCenterShowAllView.php';
include_once '../Views/Report/ReportDegreeSearchView.php';
include_once '../Views/Report/ReportDegreeShowAllView.php';
include_once '../Views/Report/ReportSubjectSearchView.php';
include_once '../Views/Report/ReportSubjectShowAllView.php';
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
$degreeDAO = new DegreeDAO();
$departmentDAO = new DepartmentDAO();
$subjectDAO = new SubjectDAO();
//Data required
$universityData = $universityDAO->showAll();
$centerData = $centerDAO->showAll();
$degreeData = $degreeDAO->showAll();
$departmentData = $departmentDAO->showAll();

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "search":
        if (!isset($_POST["entity"])) {
            new ReportSearchView();
        } else {
            switch ($_POST["entity"]) {
                case "center":
                    if (!isset($_POST["university"])) {
                        new ReportCenterSearchView($universityData);
                    } else {
                        try {
                            $sql = "SELECT CENTER.* FROM CENTER";
                            $universityId = $_POST["university"];
                            if ($universityId != "") {
                                $sql .= ", UNIVERSITY WHERE UNIVERSITY.id =" . $universityId . ";";
                            }
                            $reportDump = returnData($sql);
                            $centers = $centerDAO->getCentersFromDB($reportDump);
                            new ReportCenterShowAllView($centers);
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
                            $sql = "SELECT d.* FROM DEGREE d";
                            $universityId = $_POST["university"];
                            $centerId = $_POST["center"];
                            if ($universityId != "" and $centerId == "") {
                                $sql .= ", CENTER c WHERE d.center_id=c.id AND c.university_id=" . $universityId;
                            } elseif ($universityId != "" and $centerId != "") {
                                $sql .= ", CENTER c WHERE d.center_id=" . $centerId . " AND c.university_id=" . $universityId;
                            } elseif ($universityId == "" and $centerId != "") {
                                $sql .= " WHERE d.center_id=" . $centerId;
                            }

                            $reportDump = returnData($sql . ";");
                            $degrees = $degreeDAO->getDegreesFromDB($reportDump);

                            new ReportDegreeShowAllView($degrees);
                        } catch (DAOException $e) {
                            goToShowAllAndShowError($e->getMessage());
                        } catch (ValidationException $ve) {
                            goToShowAllAndShowError($ve->getMessage());
                        }
                    }
                    break;

                case "subject":
                    if (!isset($_POST["degree"])) {
                        new ReportSubjectSearchView($degreeData, $departmentData);
                    } else {
                        try {
                            $sql = "SELECT s.* FROM SUBJECT s";
                            $degreeId = $_POST["degree"];
                            $departmentId = $_POST["department"];
                            $type = $_POST["type"];
                            $quarter = $_POST["quarter"];
                            $course = $_POST["course"];

                            $is_first_condition = true;

                            if ($departmentId != "" and $degreeId == "") {
                                $sql .= ", DEGREE d WHERE s.degree_id=d.id AND s.department_id=" . $departmentId;
                                $is_first_condition = false;
                            } elseif ($departmentId != "" and $degreeId != "") {
                                $sql .= " WHERE s.degree_id=" . $degreeId . " AND s.department_id=" . $departmentId;
                                $is_first_condition = false;
                            } elseif ($departmentId == "" and $degreeId != "") {
                                $sql .= " WHERE s.degree_id=" . $degreeId;
                                $is_first_condition = false;
                            }

                            if ($type != "" and $is_first_condition) {
                                $sql .= " WHERE s.type='" . $type . "'";
                                $is_first_condition = false;
                            } elseif ($type != "") {
                                $sql .= " AND s.type=" . $type;
                            }
                            if ($quarter != "" and $is_first_condition) {
                                $sql .= " WHERE s.quarter=" . $quarter;
                                $is_first_condition = false;
                            } elseif ($quarter != "") {
                                $sql .= " AND s.quarter=" . $quarter;
                            }
                            if ($course != "" and $is_first_condition) {
                                $sql .= " WHERE s.course=" . $course;
                            } elseif ($course != "") {
                                $sql .= " AND s.course=" . $course;
                            }

                            print($sql);

                            $reportDump = returnData($sql . ";");

                            print($reportDump);

                            $subjects = $subjectDAO->getSubjectsFromDB($reportDump);

                            new ReportSubjectShowAllView($subjects);
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

