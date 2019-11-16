<?php
declare (strict_types=1);
use PHPUnit\Framework\TestCase;
require_once '../Models/AcademicCourse/AcademicCourse.php';
require_once '../Models/AcademicCourse/AcademicCourseDAO.php';
require_once '../Models/Common/DAOException.php';
include_once './testDB.php';
final class AcademicCourseTest extends TestCase
{
    protected static $academicCourseDAO;
    protected static $exampleAcademicCourse;
    public static function setUpBeforeClass(): void

    {
        initTestDB();
        self::$academicCourseDAO = new AcademicCourseDAO();
        self::$exampleAcademicCourse = new AcademicCourse(1, '50/51', 2050, 2051);
    }

    protected function tearDown(): void
    {
        try {
            self::$academicCourseDAO->delete('academic_course_abbr', '50/51');
        } catch (Exception $e) {
        }
    }

    public static function tearDownAfterClass(): void
    {
        try {
            initTestDB();
        } catch (Exception $e) {
        }
    }

    public function testCanBeCreated()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        $this->assertInstanceOf(
            AcademicCourse::class,
            $academicCourse
        );
    }

    public function testCanBeAdded()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        $academicCourseCreated = self::$academicCourseDAO->show('academic_course_abbr', '50/51');
        $this->assertInstanceOf(AcademicCourse::class, $academicCourseCreated);
    }

    public function testCanBeUpdated()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        $academicCourse->setAcademicCourseAbbr($academicCourse->formatAbbr(2051, 2052));
        $academicCourse->setStartYear(2051);
        $academicCourse->setEndYear(2052);
        self::$academicCourseDAO->edit($academicCourse);
        $academicCourseCreated = self::$academicCourseDAO->show('academic_course_abbr', '51/52');
        $this->assertEquals($academicCourseCreated->getStartYear(), 2051);
        self::$academicCourseDAO->delete('academic_course_abbr', '51/52');
    }

    public function testCanBeDeleted()
    {
        $academicCourse = clone self::$exampleAcademicCourse;
        self::$academicCourseDAO->add($academicCourse);
        self::$academicCourseDAO->delete('academic_course_abbr', '50/51');
        $this->expectException(DAOException::class);
        $academicCourseCreated = self::$academicCourseDAO->show('academic_course_abbr', '50/51');
    }

    public function testCanShowNone()
    {
        $academicCourseCreated = self::$academicCourseDAO->showAll('academic_course_abbr', '50/51');
        $this->assertEmpty($academicCourseCreated);
    }

    public function testCanShowSeveral()
    {
        $academicCourse1 = clone self::$exampleAcademicCourse;
        $academicCourse1->setId(1);
        $academicCourse1->setAcademicCourseAbbr($academicCourse1->formatAbbr(2051, 2052));
        $academicCourse2 = clone self::$exampleAcademicCourse;
        $academicCourse2->setId(2);
        $academicCourse2->setAcademicCourseAbbr($academicCourse2->formatAbbr(2052, 2053));
        $academicCourse3 = clone self::$exampleAcademicCourse;
        $academicCourse3->setId(3);
        $academicCourse3->setAcademicCourseAbbr($academicCourse3->formatAbbr(2053, 2054));
        self::$academicCourseDAO->add($academicCourse1);
        self::$academicCourseDAO->add($academicCourse2);
        self::$academicCourseDAO->add($academicCourse3);
        $academicCoursesCreated = self::$academicCourseDAO->showAll('academic_course_abbr', '50/51');
        $this->assertTrue($academicCoursesCreated[0]->getId() == 1);
        $this->assertTrue($academicCoursesCreated[1]->getId() == 2);
        $this->assertTrue($academicCoursesCreated[2]->getId() == 3);
        self::$academicCourseDAO->delete('academic_course_abbr', '51/52');
        self::$academicCourseDAO->delete('academic_course_abbr', '52/53');
        self::$academicCourseDAO->delete('academic_course_abbr', '53/54');
    }
}