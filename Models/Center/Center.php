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
        if (empty($id) || strlen($id)>8) {
            throw new ValidationException('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getUniversity()
    {
        return $this->university;
    }

    public function setUniversity($university)
    {
        if (empty($university) || strlen($university)>8) {
            throw new ValidationException('Error de validación. Id universidad incorrecto.');
        } else {
            $this->university = $university;
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

    public function getBuilding()
    {
        return $this->building;
    }

    public function setBuilding($building)
    {
        if (empty($building) || strlen($building)>8) {
            throw new ValidationException('Error de validación. Id edificio incorrecto.');
        } else {
            $this->building = $building;
        }
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        if (empty($user) || strlen($user)>9) {
            throw new ValidationException('Error de validación. Id usuario incorrecto.');
        } else {
            $this->user = $user;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
