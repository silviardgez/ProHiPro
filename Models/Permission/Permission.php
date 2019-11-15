<?php
class Permission
{
    private $id;
    private $role;
    private $func_action;

    public function __construct($id=NULL, $role=NULL, $func_action=NULL){
        $this->id = $id;
        $this->role = $role;
        $this->func_action = $func_action;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getFuncAction()
    {
        return $this->func_action;
    }

    public function setFuncAction($func_action)
    {
        $this->func_action = $func_action;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
