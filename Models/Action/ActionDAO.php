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
        $actions = array();
        foreach ($actions_db as $action) {
            array_push($actions, new Action($action["IdAction"], $action["name"], $action["description"]));
        }
        return $actions;
    }

    function add($action) {
        return $this->defaultDAO->insert($action, "IdAction");
    }

    function delete($key, $value) {
        return $this->defaultDAO->delete("action", $key, $value);
    }

    function show($key, $value) {
        $action_db = $this->defaultDAO->show("action", $key, $value);
        return new Action($action_db["IdAction"], $action_db["name"], $action_db["description"]);
    }

    function edit($action) {
        return $this->defaultDAO->edit($action, "IdAction");
    }

    function truncateTable() {
        return $this->defaultDAO->truncateTable("action");
    }
}