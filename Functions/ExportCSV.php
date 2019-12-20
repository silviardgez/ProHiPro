<?php
include_once '../Models/User/User.php';
include_once '../Models/University/University.php';
include_once '../Models/Center/Center.php';
include_once '../Models/Degree/Degree.php';
include_once '../Models/Building/Building.php';
include_once '../Models/Subject/Subject.php';
include_once '../Models/Department/Department.php';

if (isset($_POST['data'])) {
    $data = unserialize(base64_decode($_POST["data"]));
    array_to_csv_download($data, "numbers.csv");
}

function array_to_csv_download($array, $filename = "export.csv", $delimiter = ";")
{
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://output', 'w');
    // loop over the input array
    $entity = get_class($array[0]);
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . $entity . "sReport.csv" . '";');
    $first = true;
    foreach ($array as $line) {
        if ($entity == "Center") {
            if ($first) {
                $set = ["Id", "Name", "University", "Building"];
                fputcsv($f, $set, $delimiter);
                $first = false;
            }
            $set = [$line->getId(), $line->getName(), $line->getUniversity()->getName(), $line->getBuilding()->getName()];
        } elseif ($entity == "Degree") {
            if ($first) {
                $set = ["Id", "Name", "Center", "Capacity", "Description", "Credits"];
                fputcsv($f, $set, $delimiter);
                $first = false;
            }
            $set = [$line->getId(), $line->getName(), $line->getCenter()->getName(), $line->getCapacity(), $line->getDescription(), $line->getCredits()];
        } elseif ($entity == "Subject") {
            if ($first) {
                $set = ["Content", "Code", "Type", "Course", "Quarter", "Credits", "Degree", "Department_Name", "Department_Code"];
                fputcsv($f, $set, $delimiter);
                $first = false;
            }
            $set = [$line->getContent(), $line->getCode(), $line->getType(), $line->getCourse(), $line->getQuarter(), $line->getCredits(), $line->getDegree()->getName(), $line->getDepartment()->getName(), $line->getDepartment()->getCode()];
        }

        fputcsv($f, $set, $delimiter);
    }
    // tell the browser it's going to be a csv file
//    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
//    header('Content-Disposition: attachment; filename="' . $entity . "sReport.csv" . '";');
    fclose($f);
    exit;
}