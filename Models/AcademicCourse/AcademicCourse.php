<?php
class AcademicCourse
{
    private $IdAcademicCourse;
    private $start_year;
    private $end_year;

    public function __construct($idAcademicCourse=NULL, $start_year=NULL, $end_year=NULL)
    {
        $this->setIdAcademicCourse($idAcademicCourse);
        $this->setStartYear($start_year);
        $this->setEndYear($end_year);
    }


    public function getIdAcademicCourse()
    {
        return $this->IdAcademicCourse;
    }


    public function setIdAcademicCourse($idAcademicCourse)
    {
        $this->IdAcademicCourse = $idAcademicCourse;
    }


    public function getStartYear()
    {
        return $this->start_year;
    }


    public function setStartYear($start_year)
    {
        $this->start_year = $start_year;
    }


    public function getEndYear()
    {
        return $this->end_year;
    }


    public function setEndYear($end_year)
    {
        $this->end_year = $end_year;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }

}
