<?php
class UserRole
{
    private $id;
    private $role;
    private $user;

    public function __construct($id=NULL, $role=NULL, $user=NULL){
        $this->id = $id;
        $this->role = $role;
        $this->user = $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
