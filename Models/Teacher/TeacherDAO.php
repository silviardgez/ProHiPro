<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once '../Models/User/UserDAO.php';
include_once 'Teacher.php';

class TeacherDAO
{
    private $defaultDAO;
    private $spaceDAO;
    private $userDAO;

    public function __construct()
    {
        $this->defaultDAO = new DefaultDAO();
        $this->spaceDAO = new SpaceDAO();
        $this->userDAO = new UserDAO();
    }

    function showAll()
    {
        $teachers_db = $this->defaultDAO->showAll("teacher");
        return $this->getTeachersFromDB($teachers_db);
    }

    function add($teacher)
    {
        $this->defaultDAO->insert($teacher, "id");
    }

    function delete($key, $value)
    {
        $this->defaultDAO->delete("teacher", $key, $value);
    }

    function show($key, $value)
    {
        $teacher = $this->defaultDAO->show("teacher", $key, $value);
        $space = NULL;
        if (!empty($teacher["space_id"])) {
            $space = $this->spaceDAO->show("id", $teacher["space_id"]);
        }
        $user = $this->userDAO->show("login", $teacher["user_id"]);
        return new Teacher($teacher["id"], $user, $teacher["dedication"], $space);
    }

    function edit($teacher)
    {
        $this->defaultDAO->edit($teacher, "id");
    }

    function truncateTable()
    {
        $this->defaultDAO->truncateTable("teacher");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch)
    {
        $teachers_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Teacher(), $stringToSearch);
        return $this->getTeachersFromDB($teachers_db);
    }

    function countTotalTeachers($stringToSearch)
    {
        return $this->defaultDAO->countTotalEntries(new Teacher(), $stringToSearch);
    }

    function checkDependencies($value)
    {
        $this->defaultDAO->checkDependencies("teacher", $value);
    }

    private function getTeachersFromDB($teachers_db)
    {
        $teachers = array();
        foreach ($teachers_db as $teacher) {
            $space = NULL;
            if (!empty($teacher["space_id"])) {
                $space = $this->spaceDAO->show("id", $teacher["space_id"]);
            }
            $user = $this->userDAO->show("login", $teacher["user_id"]);
            array_push($teachers, new Teacher($teacher["id"], $user, $teacher["dedication"], $space));
        }
        return $teachers;
    }
}