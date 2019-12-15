<?php


class Schedule
{
    private $id;
    private $space;
    private $teacher;
    private $subject_group;
    private $start_hour;
    private $end_hour;
    private $day;

    public function __construct($id=NULL, $space=NULL, $teacher=NULL, $subjectGroup=NULL, $startHour=NULL, $endHour=NULL,
                                $day=NULL) {
        if(!empty($id)) {
            $this->constructEntity($id, $space, $teacher, $subjectGroup, $startHour, $endHour, $day);
        }
    }

    public function constructEntity($id=NULL, $space=NULL, $teacher=NULL, $subjectGroup=NULL, $startHour=NULL, $endHour=NULL,
                                    $day=NULL) {
        $this->setId($id);
        $this->setSpace($space);
        $this->setTeacher($teacher);
        $this->setSubjectGroup($subjectGroup);
        $this->setStartHour($startHour);
        $this->setEndHour($endHour);
        $this->setDay($day);
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

    public function getTeacher()
    {
        return $this->teacher;
    }

    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
    }

    public function getSubjectGroup()
    {
        return $this->subject_group;
    }

    public function setSubjectGroup($subjectGroup)
    {
        $this->subject_group = $subjectGroup;
    }

    public function getStartHour()
    {
        return $this->start_hour;
    }

    public function setStartHour($startHour)
    {
        $this->start_hour = $startHour;
    }

    public function getEndHour()
    {
        return $this->end_hour;
    }

    public function setEndHour($endHour)
    {
        $this->end_hour = $endHour;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function setDay($day)
    {
        $this->day = $day;
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