<?php
class User_Role
{
    private $IdUserRole;
    private $IdRole;
    private $login;

    public function __construct($IdUserRole=NULL, $UserLogin=NULL, $IdRole=NULL){
        $this->IdUserRole = $IdUserRole;
        $this->IdRole = $IdRole;
        $this->login = $UserLogin;
    }

    public function getIdUserRole()
    {
        return $this->IdUserRole;
    }

    public function setIdUserRole($IdUserRole)
    {
        $this->IdUserRole = $IdUserRole;
    }

    public function getIdRole()
    {
        return $this->IdRole;
    }

    public function setIdRole($IdRole)
    {
        $this->IdRole = $IdRole;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
