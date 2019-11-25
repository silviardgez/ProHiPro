<?php
session_start();
include_once '../Functions/Authentication.php';
if (!IsAuthenticated()) {
    header('Location:../index.php');
}
include_once '../Models/Department/DepartmentDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/Department/DepartmentShowAllView.php';
include_once '../Views/Department/DepartmentAddView.php';
include_once '../Views/Department/DepartmentShowView.php';
include_once '../Views/Department/DepartmentEditView.php';
include_once '../Views/Department/DepartmentSearchView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/IsAdmin.php';
include_once '../Functions/IsDepartmentOwner.php';
include_once '../Functions/IsUniversityOwner.php';
include_once '../Functions/IsCenterOwner.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

//DAOS
$departmentDAO = new DepartmentDAO();
$teacherDAO = new TeacherDAO();
//Data required
$teachersData = $teacherDAO->showAll();
$departmentPrimaryKey = "id";
$value = $_REQUEST[$departmentPrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";

switch ($action) {
    case "add":
        if (HavePermission("Department", "ADD")) {
            if (!isset($_POST["submit"])) {
                new DepartmentAddView($teachersData);
            } else {
                try {
                    $department = new Department();
                    $department->setCode($_POST["code"]);
                    $department->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    $department->setName($_POST["name"]);
                    $departmentDAO->add($department);
                    goToShowAllAndShowSuccess("Departamento añadido correctamente.");
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
        if (HavePermission("Department", "DELETE")) {
            $department = $departmentDAO->show($departmentPrimaryKey, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $departmentDAO->delete($departmentPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Departamento eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $departmentDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar departamento", "¿Está seguro de que desea eliminar " .
                        "el departamento %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/DepartmentController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Department", "SHOWCURRENT")) {
            try {
                $departmentData = $departmentDAO->show($departmentPrimaryKey, $value);
                new DepartmentShowView($departmentData);
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
        if (HavePermission("Department", "EDIT")) {
            try {
                $department = $departmentDAO->show($departmentPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new DepartmentEditView($department, $teachersData);
                } else {
                    $department->setId($value);
                    $department->setCode($_POST["code"]);
                    $department->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    $department->setName($_POST["name"]);
                    $departmentDAO->edit($department);
                    goToShowAllAndShowSuccess("Departamento editado correctamente.");
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
        if (HavePermission("Department", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new DepartmentSearchView($teachersData);
            } else {
                try {
                    $department = new Department();
                    if (!empty($_POST["teacher_id"])) {
                        $department->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    }
                    if (!empty($_POST["name"])) {
                        $department->setName($_POST["name"]);
                    }
                    if (!empty($_POST["code"])) {
                        $department->setCode($_POST["code"]);
                    }
                    showAllSearch($department);
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
    if (HavePermission("Department", "SHOWALL")) {
        try {
            $university = IsUniversityOwner();
            if(!IsAdmin() && $university===false){
                $departments = IsDepartmentOwner();
                if($departments===false){
                    new DepartmentShowAllView(array());
                }else{
                    $departmentsData=array();
                    $currentPage = getCurrentPage();
                    $itemsPerPage = getItemsPerPage();
                    $toSearch = getToSearch($search);
                    $totalDepartments = $GLOBALS["departmentDAO"]->countTotalDepartments($toSearch);
                    $data = $GLOBALS["departmentDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
                    foreach ($data as $dat){
                        if(in_array($dat,$departments)){
                            array_push($departmentsData,$dat);
                        }
                    }
                    new DepartmentShowAllView($departmentsData, $itemsPerPage, $currentPage, $totalDepartments, $toSearch);
                }
            }else{
                $currentPage = getCurrentPage();
                $itemsPerPage = getItemsPerPage();
                $toSearch = getToSearch($search);
                $totalDepartments = $GLOBALS["departmentDAO"]->countTotalDepartments($toSearch);
                $departmentsData = $GLOBALS["departmentDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
                new DepartmentShowAllView($departmentsData, $itemsPerPage, $currentPage, $totalDepartments, $toSearch);
            }
        } catch (DAOException $e) {
            new DepartmentShowAllView(array());
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