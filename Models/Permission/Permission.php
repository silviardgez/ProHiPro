<?php
class Permission
{
    private $IdPermission;
    private $IdRole;
    private $IdFuncAction;

    public function __construct($IdPermission=NULL, $IdRole=NULL, $IdFuncAction=NULL){
        $this->IdPermission = $IdPermission;
        $this->IdRole = $IdRole;
        $this->IdFuncAction = $IdFuncAction;
    }

    public function getIdPermission()
    {
        return $this->IdPermission;
    }

    public function setIdPermission($IdPermission)
    {
        $this->IdPermission = $IdPermission;
    }

    public function getIdRole()
    {
        return $this->IdRole;
    }

    public function setIdRole($IdRole)
    {
        $this->IdRole = $IdRole;
    }

    public function getIdFuncAction()
    {
        return $this->IdFuncAction;
    }

    public function setIdFuncAction($IdFuncAction)
    {
        $this->IdFuncAction = $IdFuncAction;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
