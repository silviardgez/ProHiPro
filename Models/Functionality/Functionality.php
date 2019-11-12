<?php
class Functionality
{
    private $id;
    private $name;
    private $description;


    public function __construct($id=NULL, $name=NULL, $description=NULL){
        if (!empty($name) && !empty($description)) {
            $this->constructEntity($id, $name, $description);
        }
    }

    private function constructEntity($id=NULL, $name=NULL, $description=NULL){
        $this->setId($id);
        $this->setName($name);
        $this->setDescription($description);

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
        if (strlen($name)>60 || empty($name)) {
            throw new ValidationException('Error de validación.');
        } else {
            $this->name = $name;
        }
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        if (strlen($description)>100 || empty($description)) {
            throw new ValidationException('Error de validación.');
        } else {
            $this->description = $description;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
