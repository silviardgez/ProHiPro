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
        $academicCourses_db = $this->defaultDAO->showAll("academicCourse");
        return $this->getAcademicCoursesFromDB($academicCourses_db);
    }

    function add($academicCourse) {
        return $this->defaultDAO->insert($academicCourse, "id_academic_course");
    }

    function delete($key, $value) {
        return $this->defaultDAO->delete("academicCourse", $key, $value);
    }

    function show($key, $value) {
        $academicCourse_db = $this->defaultDAO->show("academicCourse", $key, $value);
        return new AcademicCourse($academicCourse_db["id_academic_course"],$academicCourse_db["academic_course_abbr"],
            $academicCourse_db["start_year"], $academicCourse_db["end_year"]);
    }

    function edit($academicCourse) {
        return $this->defaultDAO->edit($academicCourse, "id_academic_course");
    }

    function truncateTable() {
        return $this->defaultDAO->truncateTable("academicCourse");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $academicCoursesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new AcademicCourse(), $stringToSearch);
        return $this->getAcademicCoursesFromDB($academicCoursesDB);
    }

    function countTotalAcademicCourses($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new AcademicCourse(), $stringToSearch);
    }

    private function getAcademicCoursesFromDB($academicCourses_db) {
        $academicCourses = array();
        foreach ($academicCourses_db as $academicCourse) {
            array_push($academicCourses, new AcademicCourse($academicCourse["id_academic_course"],
                $academicCourse["academic_course_abbr"], $academicCourse["start_year"], $academicCourse["end_year"]));
        }
        return $academicCourses;
    }
}
