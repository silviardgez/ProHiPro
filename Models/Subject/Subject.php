<?php

class Subject
{
    private $id;
    private $code;
    private $content;
    private $type;
    private $department;
    private $area;
    private $course;
    private $quarter;
    private $credits;
    private $new_registration;
    private $repeaters;
    private $effective_students;
    private $enrolled_hours;
    private $taught_hours;
    private $hours;
    private $students;
    private $degree;
    private $teacher;

    public function __construct($id = NULL, $code = NULL, $content = NULL, $type = NULL, $department = NULL, $area = NULL, $course = NULL,
                                $quarter = NULL, $credits = NULL, $newRegistration = NULL, $repeaters = NULL, $effectiveStudents = NULL, $enrolledHours = NULL,
                                $taughtHours = NULL, $hours = NULL, $students = NULL, $degree = NULL, $teacher = NULL)
    {
        if (!empty($id)) {
            $this->constructEntity($id, $code, $content, $type, $department, $area, $course, $quarter, $credits,
                $newRegistration, $repeaters, $effectiveStudents, $enrolledHours, $taughtHours,
                $hours, $students, $degree, $teacher);
        }
    }

    public function constructEntity($id = NULL, $code = NULL, $content = NULL, $type = NULL, $department = NULL, $area = NULL, $course = NULL,
                                    $quarter = NULL, $credits = NULL, $newRegistration = NULL, $repeaters = NULL, $effectiveStudents = NULL,
                                    $enrolledHours = NULL, $taughtHours = NULL, $hours = NULL, $students = NULL, $degree = NULL, $teacher = NULL)
    {

        $this->setId($id);
        $this->setCode($code);
        $this->setContent($content);
        $this->setType($type);
        $this->setDepartment($department);
        $this->setArea($area);
        $this->setCourse($course);
        $this->setQuarter($quarter);
        $this->setCredits($credits);
        $this->setNewRegistration($newRegistration);
        $this->setRepeaters($repeaters);
        $this->setEffectiveStudents($effectiveStudents);
        $this->setEnrolledHours($enrolledHours);
        $this->setTaughtHours($taughtHours);
        $this->setHours($hours);
        $this->setStudents($students);
        $this->setDegree($degree);
        $this->setTeacher($teacher);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function setArea($area)
    {
        $this->area = $area;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function setCourse($course)
    {
        $this->course = $course;
    }

    public function getQuarter()
    {
        return $this->quarter;
    }

    public function setQuarter($quarter)
    {
        $this->quarter = $quarter;
    }

    public function getCredits()
    {
        return $this->credits;
    }

    public function setCredits($credits)
    {
        $this->credits = $credits;
    }

    public function getNewRegistration()
    {
        return $this->new_registration;
    }

    public function setNewRegistration($new_registration)
    {
        $this->new_registration = $new_registration;
    }

    public function getRepeaters()
    {
        return $this->repeaters;
    }

    public function setRepeaters($repeaters)
    {
        $this->repeaters = $repeaters;
    }

    public function getEffectiveStudents()
    {
        return $this->effective_students;
    }

    public function setEffectiveStudents($effective_students)
    {
        $this->effective_students = $effective_students;
    }

    public function getEnrolledHours()
    {
        return $this->enrolled_hours;
    }

    public function setEnrolledHours($enrolled_hours)
    {
        $this->enrolled_hours = $enrolled_hours;
    }

    public function getTaughtHours()
    {
        return $this->taught_hours;
    }

    public function setTaughtHours($taught_hours)
    {
        $this->taught_hours = $taught_hours;
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function setHours($hours)
    {
        $this->hours = $hours;
    }

    public function getStudents()
    {
        return $this->students;
    }

    public function setStudents($students)
    {
        $this->students = $students;
    }

    public function getDegree()
    {
        return $this->degree;
    }

    public function setDegree($degree)
    {
        $this->degree = $degree;
    }

    public function getTeacher()
    {
        return $this->teacher;
    }

    public function setTeacher($teacher)
    {
        if ($teacher == NULL) {
            $this->teacher = new Teacher();
        } else {
            $this->teacher = $teacher;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }

}