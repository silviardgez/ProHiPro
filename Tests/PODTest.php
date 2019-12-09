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
include_once '../Models/SubjectTeacher/SubjectTeacherDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class PODTest extends TestCase
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

        $user1 = new User('_test_1', 'test_pass', '36073379H', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        $user2 = new User('_test_2', 'test_pass', '34970217M', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        self::$userDAO->add($user1);
        self::$userDAO->add($user2);

        $building = new Building(3, 'Edificio de Físicas', 'Ourense', $user1);
        self::$buildingDAO->add($building);

        $space = new Space(1, 'Despacho 300', $building, 30);
        self::$spaceDAO->add($space);

        $teacher1 = new Teacher(1, $user1, 'Full', $space);
        $teacher2 = new Teacher(2, $user2, 'Full', $space);
        self::$teacherDAO->add($teacher1);
        self::$teacherDAO->add($teacher2);

        $department = new Department(1, 'D00x01', 'Informática', $teacher1);

        self::$departmentDAO->add(new Department(1, 'D00x01', 'Informática', $teacher1));

        $academicCourse = new AcademicCourse(1, '50/51', 2050, 2051);
        self::$academicCourseDAO->add($academicCourse);

        $university = new University(1, $academicCourse, 'Uvigo', $user1);
        self::$universityDAO->add($university);

        $center = new Center(1, $university, 'ESEI', $building, $user1);
        self::$centerDAO->add($center);

        $degree = new Degree(1, 'Grao en Traballo Social', $center, 120, 'Grado', 240, $user1);
        self::$degreeDAO->add($degree);

        $subject1 = new Subject(1, 'G110934', 'Test', 'A', $department, 'Inf', 1, 1, 6, 60, 30, 90, 150, 100, 50, 150, $degree, $teacher1);
        $subject2 = new Subject(2, 'G110406', 'Test', 'A', $department, 'Inf', 1, 1, 6, 60, 30, 90, 150, 100, 50, 150, $degree, $teacher1);
        $subject3 = new Subject(3, 'G120507', 'Test', 'A', $department, 'Inf', 1, 1, 6, 60, 30, 90, 150, 100, 50, 150, $degree, $teacher1);
        $subject4 = new Subject(4, 'G220902', 'Test', 'A', $department, 'Inf', 1, 1, 6, 60, 30, 90, 150, 100, 50, 150, $degree, $teacher1);
        $subject5 = new Subject(5, 'G110901', 'Test', 'A', $department, 'Inf', 1, 1, 6, 60, 30, 90, 150, 100, 50, 150, $degree, $teacher1);
        self::$subjectDAO->add($subject1);
        self::$subjectDAO->add($subject2);
        self::$subjectDAO->add($subject3);
        self::$subjectDAO->add($subject4);
        self::$subjectDAO->add($subject5);

        $source_pdf = "files/pod.pdf";
        $output_folder = "files";

        $a = passthru("pdftohtml -enc UTF-8 $source_pdf $output_folder/pod-output", $b);
        var_dump($a);
    }

    public static function tearDownAfterClass(): void
    {
        try {
            exec("rm files/pod-output*");
            restoreDB();
        } catch (Exception $e) {
        }
    }


    private function processDepartment($department)
    {
        $area = preg_split('/(?=(\(A[0-9]+\)))/', $department);
        foreach ($area as $ar) {
            if ($ar != $area[0]) {
                self::processArea($ar);
            }

        }
    }

    private function processArea($area)
    {
        $teacher = preg_split('/(?=(([0-9]{8}[A-Z])|(2019_20.+)|(([YX])[0-9]{7}[A-Z])|(A[0-9]{4}-A.+)))/', $area);
        foreach ($teacher as $teach) {
            if ($teach != $teacher[0]) {
                self::processTeacher($teach);
            }

        }
    }

    private function processTeacher($teacher)
    {
        try {
            $teacher_data = preg_split('/[\r\n]/', $teacher);

            if (substr($teacher_data[0], 0, 8) != "2019_20_" && strlen($teacher_data[1]) > 2) {

                $userDAO = new UserDAO();
                $user = $userDAO->show("dni", $teacher_data[0]);

                $teacherDAO = new TeacherDAO();
                $tea = $teacherDAO->show("user_id", $user->getLogin());

                $subjectDAO = new SubjectDAO();

                $subjectTeacherDAO = new SubjectTeacherDAO();

                for ($i = 3; $i < count($teacher_data) - 1; $i++) {
                    $sub = new SubjectTeacher();
                    $sub->setTeacher($tea);
                    $i++;
                    if (preg_match('/G[0-9]{6}/', $teacher_data[$i])) {
                        $sub->setSubject($subjectDAO->show("code", $teacher_data[$i]));
                    } else {
                        break;
                    }
                    $i += 2;
                    if (preg_match('/[0-9]{1,3}\.[0-9]{2}/', $teacher_data[$i])) {
                        $sub->setHours(intval($teacher_data[$i]));
                    } else {
                        break;
                    }
                    $i++;
                    $subjectTeacherDAO->add($sub);
                }


            }

        } catch (DAOException $e) {
            global $error;
            $error += 1;
        }

    }


    public function testCanCreateSubjectTeachers()
    {
        $htmlContent = file_get_contents("files/pod-outputs.html");
        $DOM = new DOMDocument('1.0', 'UTF-8');
        $DOM->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));

        $Body = $DOM->getElementsByTagName('body');

        $departments = preg_split('/(?=(\(D[0-9a-z]+\)))/', $Body[0]->textContent);
        foreach ($departments as $dept) {
            self::processDepartment($dept);
        }

        $subjectTeacherDAO = new SubjectTeacherDAO();

        $subjectTeachersCreated = $subjectTeacherDAO->showAll();

        $this->assertTrue(count($subjectTeachersCreated) == 5);
    }
}
