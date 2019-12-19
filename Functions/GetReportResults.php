<?php

function initDB()
{
    error_reporting(0);

    $mysqli = new mysqli("127.0.0.1", "userTEC", "passTEC", "TEC");
    
    if ($mysqli->connect_errno) {
        throw new DAOException("Fallo al conectar a MySQL: (ERROR " . $mysqli->connect_errno . ")");
    }

    return $mysqli;
}

function returnData($sql){
    $mysqli = initDB();
    if (!($result = $mysqli->query($sql))) {
        throw new DAOException('Error de conexión con la base de datos.');
    } else {
        $arrayData = array();
        $i = 0;
        while ($data = $result->fetch_array()) {
            $arrayData[$i] = $data;
            $i++;
        }
        return $arrayData;
    }
}