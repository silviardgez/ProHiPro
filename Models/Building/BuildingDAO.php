<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/User/UserDAO.php';
include_once 'Building.php';

class BuildingDAO
{
    private $defaultDAO;
    private $userDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->userDAO = new UserDAO();
    }

    function showAll() {
        $buildings_db = $this->defaultDAO->showAll("building");
        return $this->getBuildingFromDB($buildings_db);
    }

    function add($building) {
        $this->defaultDAO->insert($building,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("building", $key, $value);
    }

    function show($key, $value) {
        $building = $this->defaultDAO->show("building", $key, $value);
        $user = $this->userDAO->show("login", $building["user_id"]);
        return new Building($building["id"],$building["name"], $building["location"],$user);
    }

    function edit($building) {
        $this->defaultDAO->edit($building, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("building");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $buildings_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Building(), $stringToSearch);
        return $this->getBuildingFromDB($buildings_db);
    }

    function countTotalBuildings($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new Building(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("building", $value);
    }

    private function getBuildingFromDB($buildingsDB) {
        $buildings = array();
        foreach ($buildingsDB as $building) {
            $user = $this->userDAO->show("login", $building["user_id"]);
            array_push($buildings, new Building($building["id"], $building["name"], $building["location"],$user));
        }
        return $buildings;
    }
}