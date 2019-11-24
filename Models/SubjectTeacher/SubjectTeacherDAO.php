<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Subject/SubjectDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once 'SubjectTeacher.php';

class SubjectTeacherDAO
{
    private $defaultDAO;
    private $subjectDAO;
    private $teacherDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->subjectDAO = new SubjectDAO();
        $this->teacherDAO = new TeacherDAO();
    }

    function showAll() {
        $subjectTeachers_db = $this->defaultDAO->showAll("subject_teacher");
        return $this->getSubjectTeachersFromDB($subjectTeachers_db);
    }

    function add($subjectTeacher) {
        $this->defaultDAO->insert($subjectTeacher,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("subject_teacher", $key, $value);
    }

    function show($key, $value) {
        $subjectTeacher = $this->defaultDAO->show("subject_teacher", $key, $value);
        $subject = $this->subjectDAO->show("id", $subjectTeacher["subject_id"]);
        $teacher = $this->teacherDAO->show("id", $subjectTeacher["teacher_id"]);
        return new SubjectTeacher($subjectTeacher["id"], $teacher, $subject, $subjectTeacher["hours"]);
    }

    function edit($subjectTeacher) {
        $this->defaultDAO->edit($subjectTeacher, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("subject_teacher");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $subjectTeacher_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new SubjectTeacher(), $stringToSearch);
        return $this->getSubjectTeachersFromDB($subjectTeacher_db);
    }

    function countTotalSubjectTeachers($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new SubjectTeacher(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("subject_teacher", $value);
    }

    private function getSubjectTeachersFromDB($subjectTeacher_db) {
        $subjectTeachers = array();
        foreach ($subjectTeacher_db as $subjectTeacher) {
            $subject = $this->subjectDAO->show("id", $subjectTeacher["subject_id"]);
            $teacher = $this->teacherDAO->show("id", $subjectTeacher["teacher_id"]);
            array_push($subjectTeachers, new SubjectTeacher($subjectTeacher["id"], $teacher, $subject, $subjectTeacher["hours"]));
        }
        return $subjectTeachers;
    }
}