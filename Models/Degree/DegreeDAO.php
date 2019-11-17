<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Center/CenterDAO.php';
include_once '../Models/User/UserDAO.php';
include_once 'Degree.php';

class DegreeDAO
{
    private $defaultDAO;
    private $centerDAO;
    private $userDAO;

    public function __construct()
    {
        $this->defaultDAO = new DefaultDAO();
        $this->centerDAO = new CenterDAO();
        $this->userDAO = new UserDAO();
    }

    function showAll()
    {
        $degrees_db = $this->defaultDAO->showAll("degree");
        return $this->getDegreesFromDB($degrees_db);
    }

    function add($degree)
    {
        $this->defaultDAO->insert($degree, "id");
    }

    function delete($key, $value)
    {
        $this->defaultDAO->delete("degree", $key, $value);
    }

    function show($key, $value)
    {
        $degree = $this->defaultDAO->show("degree", $key, $value);
        $center = $this->centerDAO->show("id", $degree["center_id"]);
        $user = $this->userDAO->show("id", $degree["user_id"]);
        return new Degree($degree["id"], $degree["name"], $center, $degree["capacity"], $degree["description"], $degree["credits"], $user);
    }

    function edit($degree)
    {
        $this->defaultDAO->edit($degree, "id");
    }

    function truncateTable()
    {
        $this->defaultDAO->truncateTable("degree");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch)
    {
        $degrees_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Degree(), $stringToSearch);
        return $this->getDegreesFromDB($degrees_db);
    }

    function countTotalDegrees($stringToSearch)
    {
        return $this->defaultDAO->countTotalEntries(new Degree(), $stringToSearch);
    }

    function checkDependencies($value)
    {
        $this->defaultDAO->checkDependencies("degree", $value);
    }

    private function getDegreesFromDB($degreesDB)
    {
        $degrees = array();
        foreach ($degreesDB as $degree) {
            $center = $this->centerDAO->show("id", $degree["center_id"]);
            $user = $this->userDAO->show("id", $degree["user_id"]);
            array_push($degrees, new Degree($degree["id"], $degree["name"], $center, $degree["capacity"], $degree["description"], $degree["credits"], $user));
        }
        return $degrees;
    }
}