<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once 'Department.php';

class DepartmentDAO
{
    private $defaultDAO;
    private $teacherDAO;

    public function __construct()
    {
        $this->defaultDAO = new DefaultDAO();
        $this->teacherDAO = new TeacherDAO();
    }

    function showAll()
    {
        $departments_db = $this->defaultDAO->showAll("department");
        return $this->getDepartmentsFromDB($departments_db);
    }

    function add($department)
    {
        $this->defaultDAO->insert($department, "id");
    }

    function delete($key, $value)
    {
        $this->defaultDAO->delete("department", $key, $value);
    }

    function show($key, $value)
    {
        $department = $this->defaultDAO->show("department", $key, $value);
        $teacher = $this->teacherDAO->show("id", $department["teacher_id"]);
        return new Department($department["id"], $department["code"], $department["name"], $teacher);
    }

    function edit($department)
    {
        $this->defaultDAO->edit($department, "id");
    }

    function truncateTable()
    {
        $this->defaultDAO->truncateTable("department");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch)
    {
        $departments_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Department(), $stringToSearch);
        return $this->getDepartmentsFromDB($departments_db);
    }

    function countTotalDepartments($stringToSearch)
    {
        return $this->defaultDAO->countTotalEntries(new Department(), $stringToSearch);
    }

    function checkDependencies($value)
    {
        $this->defaultDAO->checkDependencies("department", $value);
    }

    private function getDepartmentsFromDB($departments_db)
    {
        $departments = array();
        foreach ($departments_db as $department) {
            $teacher = $this->teacherDAO->show("id", $department["teacher_id"]);
            array_push($departments, new Department($department["id"], $department["code"], $department["name"], $teacher));
        }
        return $departments;
    }
}