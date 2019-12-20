<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/Center/Center.php';
include_once '../Models/University/University.php';
include_once '../Models/User/User.php';
include_once '../Models/Building/Building.php';
include_once '../Models/AcademicCourse/AcademicCourse.php';
include_once '../Models/Center/CenterDAO.php';
include_once '../Models/University/UniversityDAO.php';
include_once '../Models/AcademicCourse/AcademicCourseDAO.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class ReportTest extends TestCase
{
    protected static $array;

    public static function setUpBeforeClass(): void
    {
        initTestDB();
        $centerDAO = new CenterDAO();
        $universityDAO = new UniversityDAO();
        $academicCourseDAO = new AcademicCourseDAO();
        $userDAO = new UserDAO();
        $buildingDAO = new BuildingDAO();

        $acCourse = new AcademicCourse(1, '50/51', 2050, 2051);
        $academicCourseDAO->add($acCourse);
        $user = new User('_test_', 'test_pass', '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        $userDAO->add($user);
        $university = new University(1, $acCourse, "Universidade de Vigo", $user);
        $universityDAO->add($university);
        $building = new Building(1, 'Edificio Politécnico', 'Ourense', $user);
        $buildingDAO->add($building);
        $centerDAO->add(new Center(1, $university, 'ESEI', $building, $user));
        $centerDAO->add(new Center(2, $university, 'FF.CC. Ciencias ambientales', $building, $user));
        $centerDAO->add(new Center(3, $university, 'FF.CC. Ing. de los alimentos', $building, $user));
        self::$array = $centerDAO->showAll();
    }

    public static function tearDownAfterClass(): void
    {
        try {
            restoreDB();
        } catch (Exception $e) {
        }
    }

    private function array_to_csv_download($array, $filename = "export.csv", $delimiter = ";")
    {
        $f = fopen('./files/sample.csv', 'w');
        // loop over the input array
        $entity = get_class($array[0]);
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
            }
            // generate csv lines from the inner arrays
//        $set=[$line->getName(),$line->getSurname()];
            fputcsv($f, $set, $delimiter);
        }
        // tell the browser it's going to be a csv file
        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="' . $entity . "sReport.csv" . '";');
        fclose($f);
    }


    public function testCanCreateCSV()
    {
        self::array_to_csv_download(self::$array, "export.csv");
        $csv_f = fopen('./files/sample.csv', 'r');
        $lines = array();

        $lines[0] = fgets($csv_f);
        $lines[1] = fgets($csv_f);
        $lines[2] = fgets($csv_f);
        $lines[3] = fgets($csv_f);

        $this->assertEquals(preg_split("/;/", $lines[1])[1], 'ESEI');
        $this->assertEquals(preg_split("/;/", $lines[2])[1], '"FF.CC. Ciencias ambientales"');
        $this->assertEquals(preg_split("/;/", $lines[3])[1], '"FF.CC. Ing. de los alimentos"');

        fclose($csv_f);
    }
}
