<?php
include_once '../Models/Common/DefaultDAO.php';
include_once 'Func_Action.php';

class FuncActionDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $funcActions_db = $this->defaultDAO->showAll("func_action");
        $funcActions = array();
        foreach ($funcActions_db as $funcAction) {
            array_push($funcActions, new Func_Action($funcAction["IdFuncAction"], $funcAction["IdAction"], $funcAction["IdFunctionality"]));
        }
        return $funcActions;
    }

    function add($funcAction) {
        return $this->defaultDAO->insert($funcAction,"IdFuncAction");
    }

    function delete($key, $value) {
        return $this->defaultDAO->delete("func_action", $key, $value);
    }

    function show($key, $value) {
        $funcAction_db = $this->defaultDAO->show("func_action", $key, $value);
        return new Func_Action($funcAction_db["IdFuncAction"], $funcAction_db["IdAction"], $funcAction_db["IdFunctionality"]);
    }

    function edit($funcAction) {
        return $this->defaultDAO->edit($funcAction, "IdFuncAction");
    }

    function truncateTable() {
        return $this->defaultDAO->truncateTable("func_action");
    }
}