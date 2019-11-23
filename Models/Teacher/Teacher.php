<?php
class Teacher
{
    private $id;
    private $user;
    private $dedication;
    private $space;

    public function __construct($id=NULL, $user=NULL, $dedication=NULL, $space=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $user, $dedication, $space);
        }
    }

    public function constructEntity($id=NULL, $user=NULL, $dedication=NULL, $space=NULL) {
        $this->setId($id);
        $this->setUser($user);
        $this->setDedication($dedication);
        $this->setSpace($space);
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
        if (empty($user)) {
            throw new ValidationException('Error de validación. Usuario incorrecto.');
        } else {
            $this->user = $user;
        }
    }

    public function getDedication()
    {
        return $this->dedication;
    }

    public function setDedication($dedication)
    {
        if (empty($dedication) || strlen($dedication)>4) {
            throw new ValidationException('Error de validación. Dedicación incorrecta.');
        } else {
            $this->dedication = $dedication;
        }
    }

    public function getSpace()
    {
        return $this->space;
    }

    public function setSpace($space)
    {
        $this->space = $space;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
