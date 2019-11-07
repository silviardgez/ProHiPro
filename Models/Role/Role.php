<?php
class Role
{
    private $IdRole;
    private $name;
    private $description;

    public function __construct($IdRole=NULL, $name=NULL, $description=NULL){
        $this->IdRole = $IdRole;
        $this->name = $name;
        $this->description = $description;
    }

    public function getIdRole()
    {
        return $this->IdRole;
    }

    public function setIdRole($IdRole)
    {
        $this->IdRole = $IdRole;
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
