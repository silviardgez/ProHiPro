<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Subject/SubjectDAO.php';
include_once '../Models/SubjectTeacher/SubjectTeacherDAO.php';
include_once '../Models/SubjectTeacher/SubjectTeacher.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/User/User.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/PodReader/PodReaderShowAllView.php';
include_once '../Views/Common/PaginationView.php';
include_once '../Functions/HavePermission.php';
include_once '../Functions/IsAdmin.php';
include_once '../Functions/IsDepartmentOwner.php';
include_once '../Functions/IsSubjectOwner.php';
include_once '../Functions/IsSubjectTeacher.php';
include_once '../Functions/OpenDeletionModal.php';
include_once '../Functions/Redirect.php';
include_once '../Functions/Messages.php';
include_once '../Functions/Pagination.php';

$subjectPrimaryKey = "id";
$value = $_REQUEST[$subjectPrimaryKey];

$error=0;

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("PodReader", "ADD")) {
            if (!isset($_POST["submit"])) {
                new PodReaderShowAllView();
            } else {
                try {

                    $dir_subida = '/var/www/html/temp/';

                    if (!file_exists($dir_subida)) {
                        mkdir($dir_subida, 0777, true);
                    }

                    $fichero_subido = $dir_subida . basename($_FILES['file']['name']);

                    move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido);

                    $cmd = "pdftohtml -enc UTF-8 $fichero_subido $dir_subida" . "pod-out";
                    exec($cmd);

                    $htmlContent = file_get_contents($dir_subida . "pod-outs.html");
                    $DOM = new DOMDocument('1.0', 'UTF-8');
                    $DOM->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));

                    $Body = $DOM->getElementsByTagName('body');

                    $departments = preg_split('/(?=(\(D[0-9a-z]+\)))/', $Body[0]->textContent);
                    foreach ($departments as $dept) {
                        processDepartment($dept);
                    }

                    rrmdir($dir_subida);


                    goToShowAllAndShowSuccess("POD añadido correctamente. Se han producido ".$error." errores");
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
    default:
        showAll();
        break;
}

function processDepartment($department)
{
    $area = preg_split('/(?=(\(A[0-9]+\)))/', $department);
    foreach ($area as $ar) {
        if ($ar != $area[0]) {
            processArea($ar);
        }

    }
}

function processArea($area)
{
    $teacher = preg_split('/(?=(([0-9]{8}[A-Z])|(2019_20.+)|(([YX])[0-9]{7}[A-Z])|(A[0-9]{4}-A.+)))/', $area);
    foreach ($teacher as $teach) {
        if ($teach != $teacher[0]) {
            processTeacher($teach);
        }

    }
}

function processTeacher($teacher){
    try{
        $teacher_data = preg_split('/[\r\n]/',$teacher);

        if (substr($teacher_data[0],0,8)!="2019_20_" && strlen($teacher_data[1])>2) {

            $userDAO = new UserDAO();
            $user = $userDAO->show("dni", $teacher_data[0]);

            $teacherDAO = new TeacherDAO();
            $tea = $teacherDAO->show("user_id", $user->getLogin());

            $subjectDAO = new SubjectDAO();

            $subjectTeacherDAO = new SubjectTeacherDAO();

            for ($i = 3; $i<count($teacher_data)-1;$i++){
                $sub = new SubjectTeacher();
                $sub->setTeacher($tea);
                $i++;
                if (preg_match('/G[0-9]{6}/',$teacher_data[$i])){
                    $sub->setSubject($subjectDAO->show("code", $teacher_data[$i]));
                }else{break;}
                $i+=2;
                if (preg_match('/[0-9]{1,3}\.[0-9]{2}/',$teacher_data[$i])){
                    $sub->setHours(intval($teacher_data[$i]));
                }else{break;}
                $i++;
                $subjectTeacherDAO->add($sub);
            }


        }

    } catch (DAOException $e){
        global $error;
        $error+=1;
    }

}

function showAll()
{
    showAllSearch(NULL);
}

function showAllSearch($search)
{
    if (HavePermission("PodReader", "SHOWALL")) {

        new PodReaderShowAllView();

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

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        rmdir($dir);
    }
}