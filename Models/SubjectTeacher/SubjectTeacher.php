<?php
class SubjectTeacher
{
    private $id;
    private $teacher;
    private $subject;
    private $hours;

    public function __construct($id=NULL, $teacher=NULL, $subject=NULL, $hours=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $teacher, $subject, $hours);
        }
    }

    public function constructEntity($id=NULL, $teacher=NULL, $subject=NULL, $hours=NULL) {
        $this->setId($id);
        $this->setTeacher($teacher);
        $this->setSubject($subject);
        $this->setHours($hours);
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

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        if (empty($subject)) {
            throw new ValidationException('Error de validación. Asignatura incorrecta.');
        } else {
            $this->subject = $subject;
        }
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function setHours($hours)
    {
        if (empty($hours) || strlen($hours)>2) {
            if($hours==0){
                $this->hours = $hours;
            }else{
                throw new ValidationException('Error de validación. Horas incorrectas.');
            }
        } else {
            $this->hours = $hours;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
