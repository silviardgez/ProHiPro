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
include_once '../Models/Group/SubjectGroup.php';
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
include_once '../Models/Group/GroupDAO.php';
include_once '../Models/Subject/SubjectDAO.php';
include_once '../Models/Common/DAOException.php';
include_once './testDB.php';

final class GroupTest extends TestCase
{
    protected static $groupDAO;
    protected static $subjectDAO;
    protected static $exampleGroup;

    public static function setUpBeforeClass(): void
    {
        initTestDB();


        self::$groupDAO = new GroupDAO();
        self::$subjectDAO = new DegreeDAO();
        $userDAO = new UserDAO();
        $spaceDAO = new SpaceDAO();
        $buildingDAO = new BuildingDAO();
        $teacherDAO = new TeacherDAO();
        $departmentDAO = new DepartmentDAO();
        $academicCourseDAO = new AcademicCourseDAO();
        $universityDAO = new UniversityDAO();
        $centerDAO = new CenterDAO();
        $degreeDAO = new DegreeDAO();

        $user = new User('_test_', 'test_pass', '11111111A', 'test', 'test user', 'test@example.com',
            'calle falsa 123', '666444666');
        $userDAO->add($user);

        $building = new Building(3, 'Edificio de Físicas', 'Ourense', $user);
        $buildingDAO->add($building);

        $space = new Space(1, 'Despacho 300', $building, 30);
        $spaceDAO->add($space);

        $teacher = new Teacher(1, $user, 'Full', $space);
        $teacherDAO->add($teacher);

        $department = new Department(1, 'D01', 'Informática', $teacher);
        $departmentDAO->add($department);

        $academicCourse = new AcademicCourse(1, '50/51', 2050, 2051);
        $academicCourseDAO->add($academicCourse);

        $university = new University(1, $academicCourse, 'Uvigo', $user);
        $universityDAO->add($university);

        $center = new Center(1, $university, 'ESEI', $building, $user);
        $centerDAO->add($center);

        $degree = new Degree(1, 'Grado en Ing. Inf.', $center, 120, 'Grado', 240, $user);
        $degreeDAO->add($degree);

        $subject = new Subject(1, 188899, 'Test', 'A', $department, 'Inf', 1, 1, 6, 60, 30, 90, 150, 100, 50, 150, $degree, $teacher,'ACR');
        self::$subjectDAO->add($subject);

        self::$exampleGroup = new SubjectGroup(1, $subject, 'Grupo 1', 30);
    }

    protected function tearDown(): void
    {
        try {
            self::$groupDAO->delete('id', 1);
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
        $group = clone self::$exampleGroup;
        $this->assertInstanceOf(
            SubjectGroup::class,
            $group
        );
    }

    public function testCanBeAdded()
    {
        $group = clone self::$exampleGroup;
        self::$groupDAO->add($group);
        $groupCreated = self::$groupDAO->show("id", 1);
        $this->assertInstanceOf(SubjectGroup::class, $groupCreated);
    }

    public function testCanBeUpdated()
    {
        $group = clone self::$exampleGroup;
        self::$groupDAO->add($group);
        $group->setName('Grupo 2');
        self::$groupDAO->edit($group);
        $groupCreated = self::$groupDAO->show("id", 1);
        $this->assertEquals($groupCreated->getName(), 'Grupo 2');
    }

    public function testCanBeDeleted()
    {
        $group = clone self::$exampleGroup;
        self::$groupDAO->add($group);
        self::$groupDAO->delete("id", 1);

        $this->expectException(DAOException::class);
        $groupCreated = self::$groupDAO->show("id", 1);
    }

    public function testCanShowNone()
    {
        $groupCreated = self::$groupDAO->showAll();
        $this->assertEmpty($groupCreated);
    }

    public function testCanShowSeveral()
    {
        $group1 = clone self::$exampleGroup;
        $group1->setId(2);
        $group1->setName('Grupo 2');
        $group2 = clone self::$exampleGroup;
        $group2->setId(3);
        $group2->setName('Grupo 3');
        $group3 = clone self::$exampleGroup;
        $group3->setId(4);
        $group3->setName('Grupo 4');


        self::$groupDAO->add($group1);
        self::$groupDAO->add($group2);
        self::$groupDAO->add($group3);

        $groupsCreated = self::$groupDAO->showAll();

        $this->assertTrue(count($groupsCreated) == 3);
    }
}
