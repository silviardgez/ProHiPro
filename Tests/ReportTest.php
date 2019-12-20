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
include_once '../Functions/ExportCSV.php';

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
        $centerDAO->add(new Center(3, $university, 'FF.CC. Ingeniería de los alimentos', $building, $user));
        self::$array = $centerDAO->showAll();
    }

    public static function tearDownAfterClass(): void
    {
        try {
            restoreDB();
        } catch (Exception $e) {
        }
    }


    public function testCanCreateSubjectTeachers()
    {
        print_r(self::$array);
        array_to_csv_download(self::$array, "export.csv");
    }
}
