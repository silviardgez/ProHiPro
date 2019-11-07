<?php
class User
{
    private $login;
    private $password;
    private $dni;
    private $name;
    private $surname;
    private $email;
    private $address;
    private $telephone;

    public function __construct($login=NULL, $password=NULL, $dni=NULL, $name=NULL, $surname=NULL, $email=NULL,
                                $address=NULL, $telephone=NULL){
        if(!empty($login) && !empty($login)){
            $this->constructEntity($login,$password,$dni,$name,$surname,$email,$address,$telephone);
        }
    }

    private function constructEntity($login=NULL, $password=NULL, $dni=NULL, $name=NULL, $surname=NULL, $email=NULL,
                                     $address=NULL, $telephone=NULL){
        if($this->isCorrectUser($login, $password, $dni, $name, $surname, $email, $address, $telephone)) {
            $this->setLogin($login);
            $this->setPassword($password);
            $this->setDni($dni);
            $this->setName($name);
            $this->setSurname($surname);
            $this->setEmail($email);
            $this->setAddress($address);
            $this->setTelephone($telephone);
        }
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function encryptPassword($password)
    {
        return md5($password);
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    function isCorrectUser($login, $password, $dni, $name, $surname, $email, $address, $telephone){
        if($login == NULL || strlen($login)>9){
            throw new ValidationException('Error de validación.');

        }elseif($password == NULL || strlen($password)>128){
            throw new ValidationException('Error de validación.');

        }elseif($dni == NULL || strlen($dni)>9){
            throw new ValidationException('Error de validación.');

        }elseif($name == NULL || strlen($name)>30){
            throw new ValidationException('Error de validación.');

        }elseif($surname == NULL || strlen($surname)>50){
            throw new ValidationException('Error de validación.');

        }elseif($email == NULL || strlen($email)>40){
            throw new ValidationException('Error de validación.');

        }elseif($address == NULL || strlen($address)>60){
            throw new ValidationException('Error de validación.');

        }elseif($telephone == NULL || strlen($telephone)>11 || $this->checkPhone($telephone)){
            throw new ValidationException('Error de validación.');
        }else{
            return true;
        }
    }

    function checkPhone($phone){
        if(!preg_match('^(34)?[6|7|9][0-9]{8}$', $phone)){
            return false;
        }else{
            return true;
        }
    }
    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
