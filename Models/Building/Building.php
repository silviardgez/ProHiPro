<?php
class Building
{
    private $id;
    private $name;
    private $location;
    private $user;

    public function __construct($id=NULL, $name=NULL, $location=NULL, $user=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $name, $location, $user);
        }
    }

    public function constructEntity($id=NULL,$name=NULL, $location=NULL, $user=NULL) {
        $this->setId($id);
        $this->setName($name);
        $this->setLocation($location);
        $this->setUser($user);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (empty($id) || strlen($id)>8) {
            throw new ValidationException('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        if (empty($user) || strlen($user)>9) {
            throw new ValidationException('Error de validación. Usuario incorrecto.');
        } else {
            $this->user = $user;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (empty($name) || strlen($name)>30) {
            throw new ValidationException('Error de validación. Nombre incorrecto.');
        } else {
            $this->name = $name;
        }
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        if (empty($location) || strlen($location)>30) {
            throw new ValidationException('Error de validación. Localización incorrecta.');
        } else {
            $this->location = $location;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
