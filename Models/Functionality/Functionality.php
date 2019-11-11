<?php
class Functionality
{
    private $IdFunctionality;
    private $name;
    private $description;


    public function __construct($IdFunctionality=NULL, $name=NULL, $description=NULL){
        $this->IdFunctionality = $IdFunctionality;
        $this->name = $name;
        $this->description = $description;
    }

    public function getIdFunctionality()
    {
        return $this->IdFunctionality;
    }

    public function setIdFunctionality($IdFunctionality)
    {
        $this->IdFunctionality = $IdFunctionality;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if(!is_string($name) || strlen($name)>60 || $name == NULL){
            throw new DAOException('Error de validación.');
        }else{
            $this->name = $name;
        }
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        if(!is_string($description) || strlen($description)>100 || $description == NULL){
            throw new DAOException('Error de validación.');
        }else{
            $this->description = $description;
        }
    }


    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
