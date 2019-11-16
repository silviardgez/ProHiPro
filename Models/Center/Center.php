<?php
class Center
{
    private $id;
    private $university;
    private $name;
    private $building;
    private $user;

    public function __construct($id=NULL, $university=NULL, $name=NULL, $building=NULL, $user=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $university, $name, $building,$user);
        }
    }

    public function constructEntity($id=NULL, $university=NULL, $name=NULL, $building=NULL, $user=NULL) {
        $this->setId($id);
        $this->setUniversity($university);
        $this->setName($name);
        $this->setBuilding($building);
        $this->setUser($user);
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

    public function getBuilding()
    {
        return $this->building;
    }

    public function setBuilding($building)
    {
        $this->building = $building;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
