<?php
class Space
{
    private $id;
    private $name;
    private $building;
    private $capacity;
    private $office;

    public function __construct($id=NULL, $name=NULL, $building=NULL, $capacity=NULL, $office=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $name, $building, $capacity, $office);
        }
    }

    public function constructEntity($id=NULL, $name=NULL, $building=NULL, $capacity=NULL, $office=NULL) {
        $this->setId($id);
        $this->setName($name);
        $this->setBuilding($building);
        $this->setCapacity($capacity);
        $this->setOffice($office);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (empty($id) || strlen($id) > 8) {
            throw new ValidationException('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
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

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity)
    {
        if (empty($capacity) || strlen($capacity)>3) {
            throw new ValidationException('Error de validación. Capacidad incorrecta.');
        } else {
            $this->capacity = $capacity;
        }
    }

    public function isOffice()
    {
        return $this->office;
    }

    public function setOffice($office)
    {
        $office = boolval($office) ? boolval($office) : false;
        if (is_bool($office)) {
            $this->office = (int) $office;
        } else {
            throw new ValidationException('Error de validación. Despacho indicado de forma incorrecta.');
        }
    }

    public function getOffice()
    {
        return $this->office;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
