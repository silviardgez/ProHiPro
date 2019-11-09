<?php
class AcademicCourse
{
    private $id_academic_course;
    private $academic_course_abbr;
    private $start_year;
    private $end_year;

    public function __construct($id_academic_course=NULL,$academic_course_abbr=NULL , $start_year=NULL, $end_year=NULL)
    {
        if ($this->isCorrectAcademicCourse($start_year, $end_year)) {
            if($academic_course_abbr === NULL) {
                $academic_course_abbr = $this->formatAbbr($start_year, $end_year);
            }
            $this->setIdAcademicCourse($id_academic_course);
            $this->setAcademicCourseAbbr($academic_course_abbr);
            $this->setStartYear($start_year);
            $this->setEndYear($end_year);
        }
    }

    public function getIdAcademicCourse()
    {
        return $this->id_academic_course;
    }

    public function setIdAcademicCourse($id_academic_course)
    {
        $this->id_academic_course = $id_academic_course;
    }

    public function getStartYear()
    {
        return $this->start_year;
    }

    public function setStartYear($start_year)
    {
        $this->start_year = intval($start_year);
    }

    public function getEndYear()
    {
        return $this->end_year;
    }

    public function setEndYear($end_year)
    {
        $this->end_year = intval($end_year);
    }

    public function getAcademicCourseAbbr()
    {
        return $this->academic_course_abbr;
    }

    public function setAcademicCourseAbbr($academic_course_abbr)
    {
        $this->academic_course_abbr = $academic_course_abbr;
    }



    function isCorrectAcademicCourse($startYear, $endYear){
        if ($startYear >= $endYear) {
            throw new DAOException('Año de inicio mayor o igual que año fin.');
        } elseif ($startYear != ($endYear - 1)) {
            throw new DAOException('No puede existir una diferencia de más de 1 año entre cursos.');
        } else {
            return true;
        }
    }

    function formatAbbr($start_year, $end_year){
        return substr($start_year,-2) . "/" . substr($end_year,-2);
    }
    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }

}
