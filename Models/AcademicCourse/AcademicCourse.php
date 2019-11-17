<?php
class AcademicCourse
{
    private $id;
    private $academic_course_abbr;
    private $start_year;
    private $end_year;

    public function __construct($id=NULL,$academic_course_abbr=NULL, $start_year=NULL, $end_year=NULL)
    {
        if (!empty($start_year) && !empty($end_year)) {
            $this->constructEntity($id ,$academic_course_abbr, $start_year, $end_year);
        }
    }

    private function constructEntity($id=NULL,$academic_course_abbr=NULL , $start_year=NULL, $end_year=NULL) {
        if ($this->isCorrectAcademicCourse($start_year, $end_year)) {
            if($academic_course_abbr === NULL) {
                $academic_course_abbr = $this->formatAbbr($start_year, $end_year);
            }
            $this->setId($id);
            $this->setAcademicCourseAbbr($academic_course_abbr);
            $this->setStartYear($start_year);
            $this->setEndYear($end_year);
        }
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

    public function getStartYear()
    {
        return $this->start_year;
    }

    public function setStartYear($start_year)
    {
        if($start_year<2000 || $start_year>9999 || !is_numeric($start_year)){
            throw new ValidationException('Año fuera de rango.');
        } else {
            $this->start_year = intval($start_year);
        }
    }

    public function getEndYear()
    {
        return $this->end_year;
    }

    public function setEndYear($end_year)
    {
        if($end_year<2000 || $end_year>9999 || !is_numeric($end_year)){
            throw new ValidationException('Año fuera de rango.');
        } else {
            $this->end_year = intval($end_year);
        }

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
            throw new ValidationException('Año de inicio mayor o igual que año fin.');
        } elseif ($startYear != ($endYear - 1)) {
            throw new ValidationException('No puede existir una diferencia de más de 1 año entre cursos.');
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
