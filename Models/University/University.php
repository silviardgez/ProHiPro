<?php
class University
{
    private $id;
    private $academic_course;
    private $name;

    public function __construct($id=NULL, $academicCourse=NULL, $name=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $academicCourse, $name);
        }
    }

    public function constructEntity($id=NULL, $academicCourse=NULL, $name=NULL) {
        $this->id = $id;
        $this->academic_course = $academicCourse;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAcademicCourse()
    {
        return $this->academic_course;
    }

    public function setAcademicCourse($academicCourse)
    {
        $this->academic_course = $academicCourse;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
