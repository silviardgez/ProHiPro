<?php

class SubjectGroup
{
    private $id;
    private $subject;
    private $name;
    private $capacity;

    public function __construct($id = NULL, $subject = NULL, $name = NULL, $capacity = NULL)
    {
        if (!empty($subject) && !empty($name) && !empty($capacity)) {
            $this->constructEntity($id, $subject, $name, $capacity);
        }
    }

    private function constructEntity($id = NULL, $subject = NULL, $name = NULL, $capacity = NULL)
    {
        $this->setId($id);
        $this->setSubject($subject);
        $this->setName($name);
        $this->setCapacity($capacity);
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

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        if (empty($subject) || strlen($subject) > 8) {
            throw new ValidationException('Error de validación. Id centro incorrecto.');
        } else {
            $this->subject = $subject;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (strlen($name) > 30 || empty($name)) {
            throw new ValidationException('Error de validación. Nombre incorrecto.');
        } else {
            $this->name = $name;
        }
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity)
    {
        if (empty($capacity) || strlen($capacity) > 3) {
            throw new ValidationException('Error de validación. Capacidad incorrecta.');
        } else {
            $this->capacity = $capacity;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }

}
