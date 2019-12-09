<?php

session_start();
include_once '../Functions/Authentication.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../Models/Subject/Subject.php';
include_once '../Models/Department/DepartmentDAO.php';
include_once '../Models/Degree/DegreeDAO.php';
include_once '../Models/Subject/SubjectDAO.php';
include_once '../Models/Common/DAOException.php';
include_once '../Views/Common/Head.php';
include_once '../Views/Common/DefaultView.php';
include_once '../Views/PdaReader/PdaReaderShowAllView.php';
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

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (HavePermission("PDA", "ADD")) {
            if (!isset($_POST["submit"])) {
                new PdaReaderShowAllView();
            } else {
                try {

                    $dir_subida = '/var/www/html/temp/';

                    if (!file_exists($dir_subida)) {
                        mkdir($dir_subida, 0777, true);
                    }

                    $fichero_subido = $dir_subida . basename($_FILES['file']['name']);

                    move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido);

                    loadPDA($dir_subida);

                    rrmdir($dir_subida);

                    goToShowAllAndShowSuccess("PDA añadido correctamente.");
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

function showAll()
{
    showAllSearch(NULL);
}

function showAllSearch($search)
{
    if (HavePermission("PDA", "SHOWALL")) {

        new PdaReaderShowAllView();

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


function loadPDA($dir)
{
    $objects = scandir($dir);
    $source_pdf = $dir;

    foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
            $source_pdf = $dir . $object;
        }
    }
    $source_pdf = preg_replace('/\s/', '\ ', $source_pdf);

    $cmd = "pdftohtml -enc UTF-8 $source_pdf $dir" . "pda-output";

    exec($cmd);

    $htmlContent = file_get_contents($dir . "pda-outputs.html");
    $DOM = new DOMDocument('1.0', 'UTF-8');
    $DOM->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));

    $Bold = $DOM->getElementsByTagName('b');
    $Body = $DOM->getElementsByTagName('body');

    $degree = trim(preg_replace('/\(.+\)/', '', $Bold[0]->textContent));

    $pda_data = preg_split('/Presen./', $Body[0]->textContent)[1];
    $courses = preg_split('/[0-9].+Curso/', $pda_data);

    $subjects_1y = preg_split('/(?=G[0-9]{6})/', $courses[1]);
    unset($subjects_1y[0]);
    $subjects_2y = preg_split('/(?=G[0-9]{6})/', $courses[2]);
    unset($subjects_2y[0]);
    $subjects_3y = preg_split('/(?=G[0-9]{6})/', $courses[3]);
    unset($subjects_3y[0]);
    $subjects_4y = preg_split('/(?=G[0-9]{6})/', $courses[4]);
    unset($subjects_4y[0]);

    $tfg = utf8_decode(preg_split('/(Â \n){3,}/', utf8_encode(array_pop($subjects_4y)))[0]);

    loadCourse($subjects_1y, 1, $degree);
    loadCourse($subjects_2y, 2, $degree);
    loadCourse($subjects_3y, 3, $degree);
    loadCourse($subjects_4y, 4, $degree);
}

function loadCourse($subjects, $course, $degree)
{
    $degreeDAO = new DegreeDAO();
    $departmentDAO = new DepartmentDAO();
    $subjectDAO = new SubjectDAO();

    foreach ($subjects as $subject_data) {
        $subject_data = preg_split('/\n/', trim($subject_data));


        $code = substr($subject_data[0], 0, 7);
        $content = substr($subject_data[0], 9);
        unset($subject_data[0]);

        $subject_data = join(" ", $subject_data);
        $subject_data = utf8_decode(preg_replace('/Â /', ' ', utf8_encode(trim($subject_data))));
        $subject_data = preg_split('/\s/', utf8_encode(trim($subject_data)));

        if (!is_numeric($subject_data[sizeof($subject_data) - 1])) {
            $content = $content . ' ' . $subject_data[sizeof($subject_data) - 1];
        }

        $reindex = 0;
        $department = NULL;

        if ($subject_data[1][0] != 'D') {
            $reindex = 1;
            foreach ($subject_data as $datum) {
                if ($datum[0] == 'D') {
                    $department = $datum;
                }
            }
        } else {
            $department = $subject_data[1];
        }

        $type = $subject_data[0];
        $area = $subject_data[2 - $reindex];
        $quarter = $subject_data[3 - $reindex][0];
        $credits = intval($subject_data[4 - $reindex]);
        $newRegistration = intval($subject_data[5 - $reindex]);
        $repeaters = intval($subject_data[6 - $reindex]);
        $effectiveStudents = intval($subject_data[7 - $reindex]);
        $enrolledHours = $subject_data[15 - $reindex];
        $taughtHours = $subject_data[16 - $reindex];
        $hours = (string)$credits * 25;
        $students = $newRegistration + $repeaters;

        try {
            $subject = new Subject();
            $department = $departmentDAO->show("code", $department);
            $degree_obj = $degreeDAO->show("name", $degree);

            $subject->setCode($code);
            $subject->setContent($content);
            $subject->setType($type);
            $subject->setDepartment($department);
            $subject->setArea($area);
            $subject->setCourse($course);
            $subject->setQuarter($quarter);
            $subject->setCredits($credits);
            $subject->setNewRegistration($newRegistration);
            $subject->setRepeaters($repeaters);
            $subject->setEffectiveStudents($effectiveStudents);
            $subject->setEnrolledHours($enrolledHours);
            $subject->setTaughtHours($taughtHours);
            $subject->setHours($hours);
            $subject->setStudents($students);
            $subject->setDegree($degree_obj);
            $subject->setTeacher(NULL);

            $subjectDAO->add($subject);
        } catch (Exception $e) {
        }
    }
}