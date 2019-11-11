<?php
class Action
{
    private $IdAction;
    private $name;
    private $description;

    public function __construct($IdAction=NULL, $name=NULL, $description=NULL){

        if (!empty($name) && !empty($description)) {
            $this->constructEntity($IdAction,$name, $description);
        }

    }
    private function constructEntity($IdAction=NULL, $name=NULL, $description=NULL){
        if($this->isCorrect($name,$description)){
            $this->setIdAction($IdAction);
            $this->setName($name);
            $this->setDescription($description);
        }

    }

    public function getIdAction()
    {
        return $this->IdAction;
    }

    public function setIdAction($IdAction)
    {
        $this->IdAction = $IdAction;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if(strlen($name)>60){
            throw new ValidationException('Error de validación.');
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
        if(strlen($description)>100){
            throw new ValidationException('Error de validación.');
        }else{
            $this->description = $description;
        }
    }

    function isCorrect($name, $description){
        if($name == NULL || $description == NULL){
            throw new ValidationException('Error de validación');
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
