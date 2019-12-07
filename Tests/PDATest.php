<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Models/User/User.php';
include_once '../Models/Building/Building.php';
include_once '../Models/Teacher/Teacher.php';
include_once '../Models/Space/Space.php';
include_once '../Models/Department/Department.php';
include_once '../Models/AcademicCourse/AcademicCourse.php';
include_once '../Models/University/University.php';
include_once '../Models/Center/Center.php';
include_once '../Models/Degree/Degree.php';
include_once '../Models/Subject/Subject.php';
include_once '../Models/User/UserDAO.php';
include_once '../Models/Building/BuildingDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/Department/DepartmentDAO.php';
include_once '../Models/AcademicCourse/AcademicCourseDAO.php';
include_once '../Models/University/UniversityDAO.php';
include_once '../Models/Center/CenterDAO.php';
include_once '../Models/Degree/DegreeDAO.php';
include_once '../Models/Subject/SubjectDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class PDATest extends TestCase
{

    protected static $userDAO;
    protected static $spaceDAO;
    protected static $buildingDAO;
    protected static $teacherDAO;
    protected static $subjectDAO;
    protected static $departmentDAO;
    protected static $academicCourseDAO;
    protected static $universityDAO;
    protected static $centerDAO;
    protected static $degreeDAO;

    public static function setUpBeforeClass(): void
    {
        initTestDB();

        self::$subjectDAO = new SubjectDAO();
        self::$userDAO = new UserDAO();
        self::$spaceDAO = new SpaceDAO();
        self::$buildingDAO = new BuildingDAO();
        self::$teacherDAO = new TeacherDAO();
        self::$departmentDAO = new DepartmentDAO();
        self::$academicCourseDAO = new AcademicCourseDAO();
        self::$universityDAO = new UniversityDAO();
        self::$centerDAO = new CenterDAO();
        self::$degreeDAO = new DegreeDAO();

        $user = new User('_test_', 'test_pass', '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        self::$userDAO->add($user);

        $building = new Building(3, 'Edificio de Físicas', 'Ourense', $user);
        self::$buildingDAO->add($building);

        $space = new Space(1, 'Despacho 300', $building, 30);
        self::$spaceDAO->add($space);

        $teacher = new Teacher(1, $user, 'Full', $space);
        self::$teacherDAO->add($teacher);

        self::$departmentDAO->add(new Department(1, 'D00x01', 'Informática', $teacher));
        self::$departmentDAO->add(new Department(2, 'D00x02', 'Informática', $teacher));
        self::$departmentDAO->add(new Department(3, 'D00x03', 'Informática', $teacher));
        self::$departmentDAO->add(new Department(4, 'D00x04', 'Informática', $teacher));
        self::$departmentDAO->add(new Department(5, 'D00x10', 'Informática', $teacher));
        self::$departmentDAO->add(new Department(6, 'D00x11', 'Informática', $teacher));
        self::$departmentDAO->add(new Department(7, 'D00x13', 'Informática', $teacher));

        $academicCourse = new AcademicCourse(1, '50/51', 2050, 2051);
        self::$academicCourseDAO->add($academicCourse);

        $university = new University(1, $academicCourse, 'Uvigo', $user);
        self::$universityDAO->add($university);

        $center = new Center(1, $university, 'ESEI', $building, $user);
        self::$centerDAO->add($center);

        $degree = new Degree(1, 'Grao en Traballo Social', $center, 120, 'Grado', 240, $user);
        self::$degreeDAO->add($degree);

        $source_pdf = "files/pda.pdf";
        $output_folder = "files";

        $a = passthru("pdftohtml -enc UTF-8 $source_pdf $output_folder/pda-output", $b);
        var_dump($a);
    }

    public static function tearDownAfterClass(): void
    {
        try {
            exec("rm files/pda-output*");
//            restoreDB();
        } catch (Exception $e) {
        }
    }

    private function loadCourse($subjects, $course, $degree)
    {
        foreach ($subjects as $subject_data) {
            $subject_data = preg_split('/\n/', trim($subject_data));
            print_r($subject_data);

            $code = substr($subject_data[0], 0, 7);
            $content = substr($subject_data[0], 9);
            if (sizeof($subject_data) == 16 && !is_int(intval($subject_data[15]))) {
                $content = substr($subject_data[0], 9) . ' ' . $subject_data[15];
            }
            $type = substr($subject_data[1], 0, 2);
            $department = substr($subject_data[1], 4, 6);
            $area = substr($subject_data[1], 12);
            $quarter = substr($subject_data[2], 0, 1);
            $credits = intval($subject_data[3]);
            $newRegistration = intval($subject_data[4]);
            $repeaters = intval($subject_data[5]);
            $effectiveStudents = intval($subject_data[6]);
            $enrolledHours = $subject_data[9];
            $taughtHours = $subject_data[10];
            $hours = $credits * 25;
            $students = $newRegistration + $repeaters;

            $subject = new Subject();
            $subject->setCode($code);
            $subject->setContent($content);
            $subject->setType($type);
            $subject->setDepartment(self::$departmentDAO->show("code", $department));
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
            $subject->setDegree(self::$degreeDAO->show("name", $degree));
            $subject->setTeacher(NULL);

            print_r($subject);

            self::$subjectDAO->add($subject);
        }
    }

    public function testCanBeParsed()
    {
        $htmlContent = file_get_contents("files/pda-outputs.html");
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

        self::loadCourse($subjects_1y, 1, $degree);
        self::loadCourse($subjects_2y, 2, $degree);
        self::loadCourse($subjects_3y, 3, $degree);
        self::loadCourse($subjects_4y, 4, $degree);
    }
}
