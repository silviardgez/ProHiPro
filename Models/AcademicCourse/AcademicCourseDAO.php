<?php
include_once '../Models/Common/DefaultDAO.php';
include_once 'AcademicCourse.php';

class AcademicCourseDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $academicCourses_db = $this->defaultDAO->showAll("academicCourse");
        $academicCourses = array();
        foreach ($academicCourses_db as $academicCourse) {
            array_push($academicCourses, new AcademicCourse($academicCourse["IdAcademicCourse"], $academicCourse["start_year"], $academicCourse["end_year"]));
        }
        return $academicCourses;
    }

    function add($academicCourse) {
        $this->canBeCreated($academicCourse->getStartYear(), $academicCourse->getEndYear());
        $academicCourse->setIdAcademicCourse(substr($academicCourse->getStartYear(), -2)."/".substr($academicCourse->getEndYear(),-2));
        return $this->defaultDAO->insert($academicCourse, "IdAcademicCourse");
    }

    function delete($key, $value) {
        return $this->defaultDAO->delete("academicCourse", $key, $value);
    }

    function show($key, $value) {
        $academicCourse_db = $this->defaultDAO->show("academicCourse", $key, $value);
        return new AcademicCourse($academicCourse_db["IdAcademicCourse"], $academicCourse_db["start_year"], $academicCourse_db["end_year"]);
    }

    function edit($academicCourse) {
        $this->canBeEdited($academicCourse->getStartYear(), $academicCourse->getEndYear());
        $academicCourse->setIdAcademicCourse(substr($academicCourse->getStartYear(), -2)."/".substr($academicCourse->getEndYear(),-2));
        return $this->defaultDAO->insert($academicCourse, "IdAcademicCourse");
    }

    function truncateTable() {
        return $this->defaultDAO->truncateTable("academicCourse");
    }

    function canBeCreated($startYear, $endYear){

        if ($startYear >= $endYear) {
            throw new DAOException('Año de inicio mayor o igual que año fin.');
        }

        if ($startYear != ($endYear - 1)) {
            throw new DAOException('No puede existir una diferencia de más de 1 año entre cursos.');
        }
    }

    function canBeEdited($startYear, $endYear) {

        echo("ESTOY COMPROBANDO SI SE PUEDE EDITAR");
        if($startYear>=$endYear){
            throw new DAOException('Año de inicio mayor o igual que año fin.');
        }

        if($startYear!=($endYear-1)){
            throw new DAOException('No puede existir una diferencia de más de 1 año entre cursos.');
        }
    }

}
