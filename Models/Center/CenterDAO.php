<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/University/UniversityDAO.php';
include_once 'Center.php';

class CenterDAO
{
    private $defaultDAO;
    private $universityDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->universityDAO = new UniversityDAO();
    }

    function showAll() {
        $centers_db = $this->defaultDAO->showAll("center");
        return $this->getCentersFromDB($centers_db);
    }

    function add($center) {
        $this->defaultDAO->insert($center,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("center", $key, $value);
    }

    function show($key, $value) {
        $center = $this->defaultDAO->show("center", $key, $value);
        $university = $this->universityDAO->show("id", $center["university_id"]);
        return new Center($center["id"], $university, $center["name"], $center["location"]);
    }

    function edit($center) {
        $this->defaultDAO->edit($center, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("center");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $centers_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Center(), $stringToSearch);
        return $this->getCentersFromDB($centers_db);
    }

    function countTotalCenters($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new Center(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("center", $value);
    }

    private function getCentersFromDB($centersDB) {
        $centers = array();
        foreach ($centersDB as $center) {
            $university = $this->universityDAO->show("id", $center["university_id"]);
            array_push($centers, new Center($center["id"], $university, $center["name"], $center["location"]));
        }
        return $centers;
    }
}