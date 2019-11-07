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
        $functionalitys_db = $this->defaultDAO->showAll("functionality");
        $functionalitys = array();
        foreach ($functionalitys_db as $functionality) {
            array_push($functionalitys, new Functionality($functionality["IdFunctionality"], $functionality["name"], $functionality["description"]));
        }
        return $functionalitys;
    }

    function add($functionality) {
        return $this->defaultDAO->insert($functionality, "IdFunctionality");
    }

    function delete($key, $value) {
        return $this->defaultDAO->delete("functionality", $key, $value);
    }

    function show($key, $value) {
        $functionality_db = $this->defaultDAO->show("functionality", $key, $value);
        return new Functionality($functionality_db["IdFunctionality"], $functionality_db["name"], $functionality_db["description"]);
    }

    function edit($functionality) {
        return $this->defaultDAO->edit($functionality, "IdFunctionality");
    }

    function truncateTable() {
        return $this->defaultDAO->truncateTable("functionality");
    }
}