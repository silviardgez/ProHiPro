<?php
class Center
{
    private $id;
    private $university;
    private $name;
    private $location;

    public function __construct($id=NULL, $university=NULL, $name=NULL, $location=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $university, $name, $location);
        }
    }

    public function constructEntity($id=NULL, $university=NULL, $name=NULL, $location=NULL) {
        $this->setId($id);
        $this->setUniversity($university);
        $this->setName($name);
        $this->setLocation($location);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUniversity()
    {
        return $this->university;
    }

    public function setUniversity($university)
    {
        $this->university = $university;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
