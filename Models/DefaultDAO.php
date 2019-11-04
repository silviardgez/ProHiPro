<?php

class DefaultDAO
{
    var $mysqli;

    function __construct()
    {
        $this->mysqli = new mysqli("127.0.0.1", "userTEC", "passTEC", "TEC");

        if ($this->mysqli->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
    }

    function showAll($className)
    {
        $sql = "SELECT * FROM" . strtoupper($className);

        if (!($result = $this->mysqli->query($sql))) {
            return 'Error en la consulta sobre la base de datos';
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

    function insert($entity, $primary_key) {
        $attributes = array_keys($entity->expose());
        $sql_keys = "";
        $sql_values = "";
        foreach ($attributes as $attribute) {
            if($sql_keys == "") {
                $sql_keys = "(" . $attribute;
            } else {
                $sql_keys = $sql_keys . "," . $attribute;
            }
            $function_name = "get" . ucfirst($attribute);
            $value = $entity->$function_name();
            if($sql_values == "") {
                $sql_values = "('" . $value . "'";
            } else {
                $sql_values = $sql_values . ", '" . $value . "'";
            }
        }
        $primary_key_function = "get" . ucfirst($primary_key);
        $sql = "SELECT * FROM " . strtoupper(get_class($entity)) . " WHERE " . $primary_key . "='". $entity->$primary_key_function() . "';";
        if (!$result = $this->mysqli->query($sql)){
            return 'No se ha podido conectar con la base de datos';
        }
        else {
            if ($result->num_rows == 0){
                $sql = "INSERT INTO " . strtoupper(get_class($entity)) . $sql_keys . ") VALUES " . $sql_values . ")";
                $this->mysqli->query($sql);
                return 'Inserción realizada con éxito';
            } else {
                return 'Error: Ya existe en la base de datos';
            }
        }
    }

    function delete($entityName, $key, $value)
    {
        $sql = "DELETE FROM " . strtoupper($entityName) . " WHERE " . $key . "= '". $value . "'";
        if (!$result = $this->mysqli->query($sql)) {
            return 'Error en la consulta sobre la base de datos';
        } else {
            return 'Eliminado correctamente';
        }
    }

    function show($entityName, $key, $value){
        $sql = "SELECT * FROM " . strtoupper($entityName) . " WHERE " . $key . " ='" . $value ."'";
        if (!$result = $this->mysqli->query($sql)) {
            return 'Error en la consulta sobre la base de datos';
        } else {
            return $result->fetch_array();
        }
    }

    function edit($entity, $primary_key) {
        $attributes = array_keys($entity->expose());
        $sql = "";
        foreach ($attributes as $attribute) {
            $function_name = "get" . ucfirst($attribute);
            $value = $entity->$function_name();
            if($attribute != $primary_key) {
                if ($sql == "") {
                    $sql = $attribute . " = '" . $value . "'";
                } else {
                    $sql = $sql . "," . $attribute . " = '" . $value . "'";
                }
            }

        }
        $primary_key_function = "get" . ucfirst($primary_key);
        $sql_query = "SELECT * FROM " . strtoupper(get_class($entity)) . " WHERE " . $primary_key . "= '". $entity->$primary_key_function() . "'";
        if (!$result = $this->mysqli->query($sql_query)){
            return 'No se ha podido conectar con la base de datos';
        }
        else {
            if ($result->num_rows != 0){
                $sql_edit = "UPDATE " . strtoupper(get_class($entity)) . " SET " . $sql . " WHERE " . $primary_key . "= '". $entity->$primary_key_function() . "'";
                $this->mysqli->query($sql_edit);
                return 'Edición realizada con éxito';
            } else {
                return 'Error: No existe en la base de datos';
            }
        }
    }
}
