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
        $this->setLogin($login);
        $this->setPassword($password);
        $this->setDni($dni);
        $this->setName($name);
        $this->setSurname($surname);
        $this->setEmail($email);
        $this->setAddress($address);
        $this->setTelephone($telephone);
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

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
