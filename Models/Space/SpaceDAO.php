<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Building/BuildingDAO.php';
include_once 'Space.php';

class SpaceDAO
{
    private $defaultDAO;
    private $buildingDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->buildingDAO = new BuildingDAO();
    }

    function showAll() {
        $spaces_db = $this->defaultDAO->showAll("spacce");
        return $this->getSpacesFromDB($spaces_db);
    }

    function add($space) {
        $this->defaultDAO->insert($space,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("space", $key, $value);
    }

    function show($key, $value) {
        $space = $this->defaultDAO->show("space", $key, $value);
        $building = $this->buildingDAO->show("id", $space["building_id"]);
        return new Space($space["id"], $space["name"], $building, $space["capacity"]);
    }

    function edit($space) {
        $this->defaultDAO->edit($space, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("space");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $spaces_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Space(), $stringToSearch);
        return $this->getSpacesFromDB($spaces_db);
    }

    function countTotalSpaces($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new Space(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("space", $value);
    }

    private function getSpacesFromDB($spacesDB) {
        $spaces = array();
        foreach ($spacesDB as $space) {
            $building = $this->buildingDAO->show("id", $space["building_id"]);
            array_push($spaces, new Space($space["id"], $space["name"], $building,$space["capacity"]));
        }
        return $spaces;
    }
}