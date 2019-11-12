<?php
class FuncAction
{
    private $id;
    private $action;
    private $functionality;

    public function __construct($id=NULL, $action=NULL, $functionality=NULL){
        $this->id = $id;
        $this->action = $action;
        $this->functionality = $functionality;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function getFunctionality()
    {
        return $this->functionality;
    }

    public function setFunctionality($functionality)
    {
        $this->functionality = $functionality;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
