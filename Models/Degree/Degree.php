<?php

class Degree
{
    private $id;
    private $name;
    private $center;
    private $capacity;
    private $description;
    private $credits;
    private $user;

    public function __construct($id = NULL, $name = NULL, $center = NULL, $capacity = NULL, $description = NULL, $credits = NULL, $user = NULL)
    {
        if (!empty($id)) {
            $this->constructEntity($id, $name, $center, $capacity, $description, $credits, $user);
        }
    }

    public function constructEntity($id = NULL, $name = NULL, $center = NULL, $capacity = NULL, $description = NULL, $credits = NULL, $user = NULL)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setCenter($center);
        $this->setCapacity($capacity);
        $this->setDescription($description);
        $this->setCredits($credits);
        $this->setUser($user);
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
        if (empty($name) || strlen($name) > 30) {
            throw new ValidationException('Error de validación. Nombre incorrecto.');
        } else {
            $this->name = $name;
        }
    }

    public function getCenter()
    {
        return $this->center;
    }

    public function setCenter($center)
    {
        if (empty($center) || strlen($center) > 8) {
            throw new ValidationException('Error de validación. Id centro incorrecto.');
        } else {
            $this->center = $center;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        if (empty($description) || strlen($description) > 50) {
            throw new ValidationException('Error de validación. Descripción incorrecta.');
        } else {
            $this->description = $description;
        }
    }

    public function getCredits()
    {
        return $this->credits;
    }

    public function setCredits($credits)
    {
        if (empty($credits) || strlen($credits) > 3) {
            throw new ValidationException('Error de validación. Créditos incorrectos.');
        } else {
            $this->credits = $credits;
        }
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        if (empty($user) || strlen($user) > 9) {
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
