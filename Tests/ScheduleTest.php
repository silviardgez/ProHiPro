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
include_once '../Models/Group/SubjectGroup.php';
include_once '../Models/Schedule/Schedule.php';
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
include_once '../Models/Group/GroupDAO.php';
include_once '../Models/Schedule/ScheduleDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class ScheduleTest extends TestCase
{
    protected static $userDAO;
    protected static $spaceDAO;
    protected static $buildingDAO;
    protected static $teacherDAO;
    protected static $scheduleDAO;
    protected static $departmentDAO;
    protected static $academicCourseDAO;
    protected static $universityDAO;
    protected static $centerDAO;
    protected static $degreeDAO;
    protected static $exampleSchedule;

    public static function setUpBeforeClass(): void
    {
        initTestDB();


        $subjectDAO = new SubjectDAO();
        $groupDAO = new GroupDAO();
        self::$scheduleDAO = new ScheduleDAO();
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

        $subject= new Subject(1, 188899, 'Test', 'A', $department, 'Inf', 1, 1, 6, 60, 30, 90, 150, 100, 50, 150, $degree, $teacher, 'ACR');
        $subjectDAO->add($subject);

        $group = new SubjectGroup(1, $subject, 'Grupo 1', 30);
        $groupDAO->add($group);

        self::$exampleSchedule = new Schedule(1, $space, $teacher, $group, '12:00:00', '14:00:00', date("2019-12-28"));
    }

    protected function tearDown(): void
    {
        try {
            self::$scheduleDAO->delete('id', 1);
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
        $schedule = clone self::$exampleSchedule;
        $this->assertInstanceOf(
            Schedule::class,
            $schedule
        );
    }

    public function testCanBeAdded()
    {
        $schedule = clone self::$exampleSchedule;
        self::$scheduleDAO->add($schedule);
        $scheduleCreated = self::$scheduleDAO->show("id", 1);
        $this->assertInstanceOf(Schedule::class, $scheduleCreated);
    }

    public function testCanBeUpdated()
    {
        $schedule = clone self::$exampleSchedule;
        self::$scheduleDAO->add($schedule);
        $schedule->setEndHour('13:30:00');
        self::$scheduleDAO->edit($schedule);
        $scheduleCreated = self::$scheduleDAO->show("id", 1);
        $this->assertEquals($scheduleCreated->getEndHour(), '13:30:00');
    }

    public function testCanBeDeleted()
    {
        $schedule = clone self::$exampleSchedule;
        self::$scheduleDAO->add($schedule);
        self::$scheduleDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $scheduleCreated = self::$scheduleDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $scheduleCreated = self::$scheduleDAO->showAll();
        $this->assertEmpty($scheduleCreated);
    }

    public function testCanShowSeveral()
    {
        $schedule1 = clone self::$exampleSchedule;
        $schedule1->setId(2);
        $schedule1->setEndHour('13:30:00');
        $schedule2 = clone self::$exampleSchedule;
        $schedule2->setId(3);
        $schedule2->setEndHour('14:30:00');
        $schedule3 = clone self::$exampleSchedule;
        $schedule3->setId(4);
        $schedule3->setEndHour('13:40:00');


        self::$scheduleDAO->add($schedule1);
        self::$scheduleDAO->add($schedule2);
        self::$scheduleDAO->add($schedule3);

        $schedulesCreated = self::$scheduleDAO->showAll();

        $this->assertTrue(count($schedulesCreated) == 3);
    }
}
