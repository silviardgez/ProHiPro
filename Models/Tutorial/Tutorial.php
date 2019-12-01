<?php
class Tutorial
{
    private $id;
    private $teacher;
    private $space;
    private $total_hours;


    public function __construct($id=NULL, $teacher=NULL, $space=NULL, $total_hours=NULL){

        if(!empty($id)) {
            $this->constructEntity($id, $teacher, $space, $total_hours);
        }
    }

    public function constructEntity($id=NULL, $teacher=NULL, $space=NULL, $total_hours=NULL){

        $this->setId($id);
        $this->setTeacher($teacher);
        $this->setSpace($space);
        $this->setTotalHours($total_hours);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTeacher()
    {
        return $this->teacher;
    }

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
    }

    public function getSpace()
    {
        return $this->space;
    }

    public function setSpace($space)
    {
        $this->space = $space;
    }

    public function getTotalHours()
    {
        return $this->total_hours;
    }

    public function setTotalHours($total_hours)
    {
        if (empty($total_hours) || strlen($total_hours) > 3) {
            throw new ValidationException('Error de validación. Horas incorrectas.');
        }else{
            $this->total_hours = $total_hours;
        }

    }


    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }

}