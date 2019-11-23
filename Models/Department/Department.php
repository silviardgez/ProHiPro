<?php
class Department
{
    private $id;
    private $code;
    private $name;
    private $teacher;

    public function __construct($id=NULL, $code=NULL, $name=NULL, $teacher=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $code, $name, $teacher);
        }
    }

    public function constructEntity($id=NULL, $code=NULL, $name=NULL, $teacher=NULL) {
        $this->setId($id);
        $this->setCode($code);
        $this->setName($name);
        $this->setTeacher($teacher);
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

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        if (empty($code) || strlen($code)>6 || substr($code, 0, 1 ) !== "D") {
            throw new ValidationException('Error de validación. Código incorrecto.');
        } else {
            $this->code = $code;
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

    public function getTeacher()
    {
        return $this->teacher;
    }

    public function setTeacher($teacher)
    {
        if (empty($teacher)) {
            throw new ValidationException('Error de validación. Profesor incorrecto.');
        } else {
            $this->teacher = $teacher;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
