<?php
include_once '../Models/Common/DefaultDAO.php';
include_once 'Action.php';

class ActionDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $actions_db = $this->defaultDAO->showAll("action");
        return $this->getActionsFromDB($actions_db);
    }

    function add($action) {
        $this->defaultDAO->insert($action, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("action", $key, $value);
    }

    function show($key, $value) {
        $action_db = $this->defaultDAO->show("action", $key, $value);
        return new Action($action_db["id"], $action_db["name"], $action_db["description"]);
    }

    function edit($action) {
        $this->defaultDAO->edit($action, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("action");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $actionsDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Action(), $stringToSearch);
        return $this->getActionsFromDB($actionsDB);
    }

    function countTotalActions($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new Action(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("action", $value);
    }

    private function getActionsFromDB($actions_db) {
        $actions = array();
        foreach ($actions_db as $action) {
            array_push($actions, new Action($action["id"], $action["name"], $action["description"]));
        }
        return $actions;
    }
}