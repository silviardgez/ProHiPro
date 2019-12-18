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
    case "downloadCSV":
        try{
            $dir_subida = '/var/www/html/temp/';
            array_to_csv_download(array(
                array(1,2,3,4), // this array is going to be the first row
                array(1,2,3,4)), // this array is going to be the second row
                "numbers.csv"
            );

            rrmdir($dir_subida);
        }catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } catch (ValidationException $ve) {
            goToShowAllAndShowError($ve->getMessage());
        }
        //showAll();
        break;
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

function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {

    $dir_subida = '/var/www/html/temp/';

    if (!file_exists($dir_subida)) {
        mkdir($dir_subida, 0777, true);
    }

    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('/var/www/html/temp/temp.csv', 'w');

    // loop over the input array
    foreach ($array as $line) {
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter);
    }

    fclose($f);

    if( !file_exists('/var/www/html/temp/temp.csv') ) die("File not found");


    $f = fopen('/var/www/html/temp/temp.csv', 'w');
    // reset the file pointer to the start of the file
    fseek($f, 0);
    header("Cache-Control: no-cache, must-revalidate");
    // tell the browser it's going to be a csv file
    header('Content-Type: application/octet-stream;');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="temp.csv";');
    header("Content-Length: " . filesize($f));
    header('Pragma: public');
    // make php send the generated csv lines to the browser

    fpassthru($f);
    exit;
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