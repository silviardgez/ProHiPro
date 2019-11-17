<?php
class University
{
    private $id;
    private $academic_course;
    private $name;
    private $user;

    public function __construct($id=NULL, $academicCourse=NULL, $name=NULL, $user=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $academicCourse, $name, $user);
        }
    }

    public function constructEntity($id=NULL, $academicCourse=NULL, $name=NULL, $user=NULL) {
        $this->setId($id);
        $this->setAcademicCourse($academicCourse);
        $this->setName($name);
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

    public function getAcademicCourse()
    {
        return $this->academic_course;
    }

    public function setAcademicCourse($academicCourse)
    {
        if (empty($academicCourse) || strlen($academicCourse)>8) {
            throw new ValidationException('Error de validación. Id curso académico incorrecto.');
        } else {
            $this->academic_course = $academicCourse;
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
