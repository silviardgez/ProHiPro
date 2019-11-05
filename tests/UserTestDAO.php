<?php
include_once '../Models/User/UserDAO.php';

class UserTestDAO extends UserDAO {

    private $defaultDAO;

    public function __construct() {
        parent::__construct();
        $this->defaultDAO = parent::testConstruct();
    }

    function truncateTable() {
        return $this->defaultDAO->truncateTable("user");
    }
}