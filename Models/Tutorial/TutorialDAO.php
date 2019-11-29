<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Teacher/TeacherDAO.php';
include_once '../Models/Space/SpaceDAO.php';
include_once 'Tutorial.php';

class TutorialDAO
{
    private $defaultDAO;
    private $teacherDAO;
    private $spaceDAO;
    
    public function __construct()
    {
        $this->defaultDAO = new DefaultDAO();
        $this->teacherDAO = new TeacherDAO();
        $this->spaceDAO = new SpaceDAO();
    }

    function showAll()
    {
        $tutorials_db = $this->defaultDAO->showAll("tutorial");
        return $this->getTutorialsFromDB($tutorials_db);
    }

    function add($tutorial)
    {
        $this->defaultDAO->insert($tutorial, "id");
    }

    function delete($key, $value)
    {
        $this->defaultDAO->delete("tutorial", $key, $value);
    }

    function show($key, $value)
    {
        $tutorial = $this->defaultDAO->show("tutorial", $key, $value);
        $teacher = $this->teacherDAO->show("id", $tutorial["teacher_id"]);
        $space = $this->spaceDAO->show("id", $tutorial["space_id"]);

        return new Tutorial($tutorial["id"], $teacher, $space, $tutorial["total_hours"]);
    }

    function edit($tutorial)
    {
        $this->defaultDAO->edit($tutorial, "id");
    }

    function truncateTable()
    {
        $this->defaultDAO->truncateTable("tutorial");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch)
    {
        $tutorials_id = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Tutorial(), $stringToSearch);
        return $this->getTutorialsFromDB($tutorials_id);
    }

    function countTotalTutorials($stringToSearch)
    {
        return $this->defaultDAO->countTotalEntries(new Tutorial(), $stringToSearch);
    }

    function checkDependencies($value)
    {
        $this->defaultDAO->checkDependencies("tutorial", $value);
    }

    private function getTutorialsFromDB($tutorials_db)
    {
        $tutorials = array();
        foreach ($tutorials_db as $tutorial) {
            $teacher = $this->teacherDAO->show("id", $tutorial["teacher_id"]);
            $space = $this->spaceDAO->show("id", $tutorial["space_id"]);
            array_push($tutorials, new Tutorial($tutorial["id"], $teacher, $space, $tutorial["total_hours"]));
        }
        return $tutorials;
    }
}