<?php
include_once '../Models/Common/DefaultDAO.php';
include_once '../Models/Action/ActionDAO.php';
include_once '../Models/Functionality/FunctionalityDAO.php';
include_once 'FuncAction.php';
class FuncActionDAO
{
    private $defaultDAO;
    private $actionDAO;
    private $functionalityDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->actionDAO = new ActionDAO();
        $this->functionalityDAO = new FunctionalityDAO();
    }

    function showAll() {
        $funcActions_db = $this->defaultDAO->showAll("func_action");
        return $this->getFuncActionFromDB($funcActions_db);
    }

    function add($funcAction) {
        $this->defaultDAO->insert($funcAction,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("func_action", $key, $value);
    }

    function show($key, $value) {
        $funcAction_db = $this->defaultDAO->show("func_action", $key, $value);
        $action = $this->actionDAO->show("id", $funcAction_db["action_id"]);
        $functionality = $this->functionalityDAO->show("id", $funcAction_db["functionality_id"]);
        return new FuncAction($funcAction_db["id"], $action, $functionality);
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $funcAction_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new FuncAction(), $stringToSearch);
        return $this->getFuncActionFromDB($funcAction_db);
    }

    function countTotalFuncActions($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new FuncAction(), $stringToSearch);
    }

    function edit($funcAction) {
        $this->defaultDAO->edit($funcAction, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("func_action");
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("func_action", $value);
    }

    private function getFuncActionFromDB($funcActions_db) {
        $funcActions = array();
        foreach ($funcActions_db as $funcAction) {
            $action = $this->actionDAO->show("id", $funcAction["action_id"]);
            $functionality = $this->functionalityDAO->show("id", $funcAction["functionality_id"]);
            array_push($funcActions, new FuncAction($funcAction["id"],
                $action, $functionality));
        }
        return $funcActions;
    }
}