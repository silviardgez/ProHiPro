<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Degree/DegreeDAO.php';
include_once '../Models/Department/DepartmentDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Teacher/Teacher.php';
include_once 'Subject.php';

class SubjectDAO
{
    private $defaultDAO;
    private $degreeDAO;
    private $departmentDAO;
    private $teacherDAO;

    public function __construct()
    {
        $this->defaultDAO = new DefaultDAO();
        $this->degreeDAO = new DegreeDAO();
        $this->departmentDAO = new DepartmentDAO();
        $this->teacherDAO = new TeacherDAO();
    }

    function showAll()
    {
        $subjects_db = $this->defaultDAO->showAll("subject");
        return $this->getSubjectsFromDB($subjects_db);
    }

    function add($subject)
    {
        $this->defaultDAO->insert($subject, "id");
    }

    function delete($key, $value)
    {
        $this->defaultDAO->delete("subject", $key, $value);
    }

    function show($key, $value)
    {
        $subject = $this->defaultDAO->show("subject", $key, $value);
        $degree = $this->degreeDAO->show("id", $subject["degree_id"]);
        $department = $this->departmentDAO->show("id", $subject["department_id"]);
        $teacher = $this->teacherDAO->show("id", $subject["teacher_id"]);
        return new Subject($subject["id"], $subject["code"], $subject["content"], $subject["type"], $department,
                        $subject["area"], $subject["course"], $subject["quarter"], $subject["credits"],
                        $subject["new_registration"], $subject["repeaters"], $subject["effective_students"],
                        $subject["enrolled_hours"], $subject["taught_hours"], $subject["hours"],
                        $subject["students"], $degree, $teacher, $subject["acronym"]);
    }

    function edit($subject)
    {
        $this->defaultDAO->edit($subject, "id");
    }

    function truncateTable()
    {
        $this->defaultDAO->truncateTable("subject");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch)
    {
        $subjects_id = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Subject(), $stringToSearch);
        return $this->getSubjectsFromDB($subjects_id);
    }

    function countTotalSubjects($stringToSearch)
    {
        return $this->defaultDAO->countTotalEntries(new Subject(), $stringToSearch);
    }

    function checkDependencies($value)
    {
        $this->defaultDAO->checkDependencies("subject", $value);
    }

    private function getSubjectsFromDB($subjects_db)
    {
        $subjects = array();
        foreach ($subjects_db as $subject) {
            $degree = $this->degreeDAO->show("id", $subject["degree_id"]);
            $department = $this->departmentDAO->show("id", $subject["department_id"]);
            if ($subject["teacher_id"] != NULL){
                $teacher = $this->teacherDAO->show("id", $subject["teacher_id"]);
            } else {
                $teacher = new Teacher();
            }
            array_push($subjects, new Subject($subject["id"], $subject["code"], $subject["content"],
                $subject["type"], $department, $subject["area"], $subject["course"], $subject["quarter"],
                $subject["credits"], $subject["new_registration"], $subject["repeaters"], $subject["effective_students"],
                $subject["enrolled_hours"], $subject["taught_hours"], $subject["hours"], $subject["students"],
                $degree, $teacher, $subject["acronym"]));
        }
        return $subjects;
    }
}