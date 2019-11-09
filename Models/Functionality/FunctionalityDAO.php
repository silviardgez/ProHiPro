<?php
include_once '../Models/Common/DefaultDAO.php';
include_once 'Functionality.php';

class FunctionalityDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $functionalities_db = $this->defaultDAO->showAll("functionality");
        return $this->getFunctionalitiesFromDB($functionalities_db);
    }

    function add($functionality) {
        $this->defaultDAO->insert($functionality, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("functionality", $key, $value);
    }

    function show($key, $value) {
        $functionality_db = $this->defaultDAO->show("functionality", $key, $value);
        return new Functionality($functionality_db["id"], $functionality_db["name"], $functionality_db["description"]);
    }

    function edit($functionality) {
        $this->defaultDAO->edit($functionality, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("functionality");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $functionalitiesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Functionality(), $stringToSearch);
        return $this->getFunctionalitiesFromDB($functionalitiesDB);
    }

    function countTotalFunctionalities($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new Functionality(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("functionality", $value);
    }

    private function getFunctionalitiesFromDB($functionalities_db) {
        $functionalities = array();
        foreach ($functionalities_db as $functionality) {
            array_push($functionalities, new Functionality($functionality["id"],
                $functionality["name"], $functionality["description"]));
        }
        return $functionalities;
    }
}