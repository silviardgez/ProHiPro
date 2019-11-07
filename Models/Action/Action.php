<?php
class Action
{
    private $IdAction;
    private $name;
    private $description;

    public function __construct($IdAction=NULL, $name=NULL, $description=NULL){
        $this->IdAction = $IdAction;
        $this->name = $name;
        $this->description = $description;
    }

    public function getIdAction()
    {
        return $this->IdAction;
    }

    public function setIdAction($IdAction)
    {
        $this->IdAction = $IdAction;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
