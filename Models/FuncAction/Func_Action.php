<?php
class Func_Action
{
    private $IdFuncAction;
    private $IdAction;
    private $IdFunctionality;

    public function __construct($IdFuncAction=NULL, $IdAction=NULL, $IdFunctionality=NULL){
        $this->IdFuncAction = $IdFuncAction;
        $this->IdAction = $IdAction;
        $this->IdFunctionality = $IdFunctionality;
    }

    public function getIdFuncAction()
    {
        return $this->IdFuncAction;
    }

    public function setIdFuncAction($IdFuncAction)
    {
        $this->IdFuncAction = $IdFuncAction;
    }

    public function getIdAction()
    {
        return $this->IdAction;
    }

    public function setIdAction($IdAction)
    {
        $this->IdAction = $IdAction;
    }

    public function getIdFunctionality()
    {
        return $this->IdFunctionality;
    }

    public function setIdFunctionality($IdFunctionality)
    {
        $this->IdFunctionality = $IdFunctionality;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
