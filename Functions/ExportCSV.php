<?php
include '../Models/User/User.php';

$data =unserialize(base64_decode($_POST["data"]));

array_to_csv_download($data,"numbers.csv");


function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://output', 'w');
    // loop over the input array
    foreach ($array as $line) {
        // generate csv lines from the inner arrays
        $set=[$line->getName(),$line->getSurname()];
        fputcsv($f, $set, $delimiter);
    }
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    fclose($f);
    exit;
}