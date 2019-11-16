<?php
class Space
{
    private $id;
    private $name;
    private $building;
    private $capacity;

    public function __construct($id=NULL, $name=NULL, $building=NULL, $capacity=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $name, $building,$capacity);
        }
    }

    public function constructEntity($id=NULL, $name=NULL, $building=NULL, $capacity=NULL) {
        $this->setId($id);
        $this->setName($name);
        $this->setBuilding($building);
        $this->setCapacity($capacity);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
