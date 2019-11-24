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

final class SubjectTest extends TestCase
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
    protected static $exampleSubject;

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

        $department = new Department(1, 'D01', 'Informática', $teacher);
        self::$departmentDAO->add($department);

        $academicCourse = new AcademicCourse(1, '50/51', 2050, 2051);
        self::$academicCourseDAO->add($academicCourse);

        $university = new University(1, $academicCourse, 'Uvigo', $user);
        self::$universityDAO->add($university);

        $center = new Center(1, $university, 'ESEI', $building, $user);
        self::$centerDAO->add($center);

        $degree = new Degree(1, 'Grado en Ing. Inf.', $center, 120, 'Grado', 240, $user);
        self::$degreeDAO->add($degree);

        self::$exampleSubject = new Subject(1, 188899, 'Test', 'A', $department, 'Inf', 1, 1, 6, 60, 30, 90, 150, 100, 50, 150, $degree, $teacher);
    }

    protected function tearDown(): void
    {
        try {
            self::$subjectDAO->delete('id', 1);
        } catch (Exception $e) {
        }
    }

    public static function tearDownAfterClass(): void
    {
        try {
            restoreDB();
        } catch (Exception $e) {
        }
    }

    public function testCanBeCreated()
    {
        $subject = clone self::$exampleSubject;
        $this->assertInstanceOf(
            Subject::class,
            $subject
        );
    }

    public function testCanBeAdded()
    {
        $subject = clone self::$exampleSubject;
        self::$subjectDAO->add($subject);
        $subjectCreated = self::$subjectDAO->show("id", 1);
        $this->assertInstanceOf(Subject::class, $subjectCreated);
    }

    public function testCanBeUpdated()
    {
        $subject = clone self::$exampleSubject;
        self::$subjectDAO->add($subject);
        $subject->setQuarter(2);
        self::$subjectDAO->edit($subject);
        $subjectCreated = self::$subjectDAO->show("id", 1);
        $this->assertEquals($subjectCreated->getQuarter(), 2);
    }

    public function testCanBeDeleted()
    {
        $subject = clone self::$exampleSubject;
        self::$subjectDAO->add($subject);
        self::$subjectDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $subjectCreated = self::$subjectDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $subjectCreated = self::$subjectDAO->showAll();
        $this->assertEmpty($subjectCreated);
    }

    public function testCanShowSeveral()
    {
        $subject1 = clone self::$exampleSubject;
        $subject1->setId(2);
        $subject1->setCode(188002);
        $subject2 = clone self::$exampleSubject;
        $subject2->setId(3);
        $subject2->setCode(188003);
        $subject3 = clone self::$exampleSubject;
        $subject3->setId(4);
        $subject3->setCode(188004);


        self::$subjectDAO->add($subject1);
        self::$subjectDAO->add($subject2);
        self::$subjectDAO->add($subject3);

        $subjectsCreated = self::$subjectDAO->showAll();

        $this->assertTrue(count($subjectsCreated) == 3);
    }
}
