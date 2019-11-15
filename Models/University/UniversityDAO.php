<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/AcademicCourse/AcademicCourseDAO.php';
include_once 'University.php';

class UniversityDAO
{
    private $defaultDAO;
    private $academicCourseDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->academicCourseDAO = new AcademicCourseDAO();
    }

    function showAll() {
        $university_db = $this->defaultDAO->showAll("university");
        return $this->getUniversitiesFromDB($university_db);
    }

    function add($university) {
        $this->defaultDAO->insert($university,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("university", $key, $value);
    }

    function show($key, $value) {
        $university = $this->defaultDAO->show("university", $key, $value);
        $academicCourse = $this->academicCourseDAO->show("id", $university["academic_course_id"]);
        return new University($university["id"], $academicCourse, $university["name"]);
    }

    function edit($university) {
        $this->defaultDAO->edit($university, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("university");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $universitiesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new University(), $stringToSearch);
        return $this->getUniversitiesFromDB($universitiesDB);
    }

    function countTotalUniversities($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new University(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("university", $value);
    }

    private function getUniversitiesFromDB($universitiesDB) {
        $universities = array();
        foreach ($universitiesDB as $university) {
            $academicCourse = $this->academicCourseDAO->show("id", $university["academic_course_id"]);
            array_push($universities, new University($university["id"], $academicCourse, $university["name"]));
        }
        return $universities;
    }
}