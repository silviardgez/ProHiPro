<?php
include_once '../Models/Common/DefaultDAO.php';
include_once 'AcademicCourse.php';

class AcademicCourseDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $academicCourses_db = $this->defaultDAO->showAll("academic_course");
        return $this->getAcademicCoursesFromDB($academicCourses_db);
    }

    function add($academicCourse) {
        $this->defaultDAO->insert($academicCourse, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("academic_course", $key, $value);
    }

    function show($key, $value) {
        $academicCourse_db = $this->defaultDAO->show("academic_course", $key, $value);
        return new AcademicCourse($academicCourse_db["id"], $academicCourse_db["academic_course_abbr"],
            $academicCourse_db["start_year"], $academicCourse_db["end_year"]);
    }

    function edit($academicCourse) {
        $this->defaultDAO->edit($academicCourse, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("academic_course");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $academicCoursesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage,
            new AcademicCourse(), $stringToSearch);
        return $this->getAcademicCoursesFromDB($academicCoursesDB);
    }

    function countTotalAcademicCourses($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new AcademicCourse(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("academic_course", $value);
    }

    private function getAcademicCoursesFromDB($academicCourses_db) {
        $academicCourses = array();
        foreach ($academicCourses_db as $academicCourse) {
            array_push($academicCourses, new AcademicCourse($academicCourse["id"],
                $academicCourse["academic_course_abbr"], $academicCourse["start_year"], $academicCourse["end_year"]));
        }
        return $academicCourses;
    }
}
