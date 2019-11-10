<?php

class DefaultDAO
{
    var $mysqli;

    function __construct()
    {
        error_reporting(0);
        if (isset($_SESSION['env']) && $_SESSION['env'] == 'test') {
            $this->mysqli = new mysqli("127.0.0.1", "userTEC", "passTEC", "testTEC");
        } else {
            $this->mysqli = new mysqli("127.0.0.1", "userTEC", "passTEC", "TEC");
        }

        if ($this->mysqli->connect_errno) {
            throw new DAOException("Fallo al conectar a MySQL: (ERROR " . $this->mysqli->connect_errno . ")");
        }
    }

    function showAll($className)
    {
        $sql = "SELECT * FROM " . strtoupper($className);
        return $this->getArrayFromSqlQuery($sql);
    }

    function insert($entity, $primary_key)
    {
        $attributes = array_keys($entity->expose());
        $sql_keys = "";
        $sql_values = "";
        foreach ($attributes as $attribute) {
            if ($sql_keys == "") {
                $sql_keys = "(" . $attribute;
            } else {
                $sql_keys = $sql_keys . "," . $attribute;
            }
            $function_name = $this->changeFunctionName($attribute);
            $value = $entity->$function_name();
            $value = $this->checkValueType($value);

            if ($sql_values == "") {
                $sql_values = "(" . $value;
            } else {
                $sql_values = $sql_values . ", " . $value;
            }
        }

        $primary_key_function = $this->changeFunctionName($primary_key);

        $sql = "SELECT * FROM " . strtoupper(get_class($entity)) . " WHERE " . $primary_key . "='".
            $entity->$primary_key_function() . "'";
        if (!$result = $this->mysqli->query($sql)){
            throw new DAOException('Error de conexión con la base de datos.');
        }
        else {
            if ($result->num_rows == 0){
                $sql = "INSERT INTO " . strtoupper(get_class($entity)) . $sql_keys . ") VALUES " . $sql_values . ")";
                if(!$resultInsertion = $this->mysqli->query($sql)) {
                    throw new DAOException('Entidad duplicada. Ya existe en la base de datos.');
                }
            } else {
               throw new DAOException('Entidad duplicada. Ya existe en la base de datos.');
            }
        }
    }

    function delete($entityName, $key, $value)
    {
        $sql = "SELECT * FROM " . strtoupper($entityName) . " WHERE " . $key . "='". $value . "'";
        if (!$result = $this->mysqli->query($sql)) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            if ($result->num_rows != 0) {
                $sql = "DELETE FROM " . strtoupper($entityName) . " WHERE " . $key . "= '" . $value . "'";
                $this->mysqli->query($sql);
            } else {
                throw new DAOException('La entidad que se intenta eliminar no existe.');
            }
        }
    }

    function show($entityName, $key, $value)
    {
        $sql = "SELECT * FROM " . strtoupper($entityName) . " WHERE " . $key . " ='" . $value . "'";

        if (!$result = $this->mysqli->query($sql)) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            if($result->num_rows > 0) {
                return $result->fetch_array();
            } else {
                throw new DAOException('La entidad consultada no existe.');
            }
        }
    }

    function edit($entity, $primary_key)
    {
        $attributes = array_keys($entity->expose());
        $sql = "";
        foreach ($attributes as $attribute) {
            $function_name = $this->changeFunctionName($attribute);
            $value = $entity->$function_name();
            $value = $this->checkValueType($value);

            if ($attribute != $primary_key) {
                if ($sql == "") {
                    $sql = $attribute . " = " . $value;
                } else {
                    $sql = $sql . ", " . $attribute . " = " . $value;
                }
            }
        }
        $primary_key_function = $this->changeFunctionName($primary_key);
        $sql_query = "SELECT * FROM " . strtoupper(get_class($entity)) . " WHERE " . $primary_key . "= '" .
            $entity->$primary_key_function() . "'";
        if (!$result = $this->mysqli->query($sql_query)) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            if ($result->num_rows != 0) {
                $sql_edit = "UPDATE " . strtoupper(get_class($entity)) . " SET " . $sql . " WHERE " .
                    $primary_key . "= '" . $entity->$primary_key_function() . "'";
                if(!$resultEdit = $this->mysqli->query($sql_edit)) {
                    throw new DAOException($this->mysqli->error);
                }
            } else {
                throw new DAOException('La entidad a editar no existe en la base de datos.');
            }
        }
    }

    public function truncateTable($entityName)
    {
        $sql = "DELETE FROM " . strtoupper($entityName);
        if (!$result = $this->mysqli->query($sql)) {
            throw new DAOException('Error en la consulta sobre la base de datos');
        }
    }

    function countTotalEntries($entity, $stringToSearch) {
        $sql = "SELECT COUNT(*) FROM " . strtoupper(get_class($entity));
        if(get_class($stringToSearch) == "DefaultDAO") {
            if (!is_null($stringToSearch)) {
                $sqlWhere = $this->getSearchConsult($entity, $stringToSearch);
                $sql .= " WHERE " . $sqlWhere;
            }
        } else {
            $sqlWhere = $this->getSearchConsultWithEntity($stringToSearch);
            $sql .= " WHERE " . $sqlWhere;
        }
        if (!($result = $this->mysqli->query($sql))) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            return $result->fetch_row()[0];
        }
    }

    function showAllPaged($currentPage, $itemsPerPage, $entity, $stringToSearch) {
        $startBlock = ($currentPage - 1) * $itemsPerPage;
        $sql = "SELECT * FROM " . strtoupper(get_class($entity));
        if(get_class($stringToSearch) == "DefaultDAO") {
            if (!is_null($stringToSearch)) {
                $sqlWhere = $this->getSearchConsult($entity, $stringToSearch);
                $sql .= " WHERE " . $sqlWhere;
            }
        } else {
            $sqlWhere = $this->getSearchConsultWithEntity($stringToSearch);
            $sql .= " WHERE " . $sqlWhere;
        }
        $sql .= " LIMIT " . $startBlock . "," . $itemsPerPage;
        return $this->getArrayFromSqlQuery($sql);
    }

    private function changeFunctionName($attribute)
    {
        if(strpos($attribute, "_") !== FALSE) {
            $splitted = explode("_", $attribute);
            $function_name = "get";
            foreach ($splitted as $split) {
                $function_name .= ucfirst($split);
            }
        } else {
            $function_name = "get" . ucfirst($attribute);
        }
        return $function_name;
    }

    private function checkValueType($value)
    {
        $valueToReturn = $value;
        if (empty($value)) {
            $valueToReturn = "NULL";
        } elseif (!is_int($value)) {
            $valueToReturn = "'" . $value . "'";
        }
        return $valueToReturn;
    }

    private function getArrayFromSqlQuery($sql) {
        if (!($result = $this->mysqli->query($sql))) {
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

    private function getSearchConsult($entity, $stringToSearch) {
        $attributes = array_keys($entity->expose());
        $sql = "";
        foreach ($attributes as $attribute) {
            if ($sql == "") {
                $sql = "(" . $attribute . " LIKE '%" . $stringToSearch . "%')";
            } else {
                $sql = $sql . " OR (" . $attribute . " LIKE '%" . $stringToSearch . "%')";
            }
        }
        return $sql;
    }

    private function getSearchConsultWithEntity($stringToSearch) {
        $attributes = array_keys($stringToSearch->expose());
        $sql = "";
        foreach ($attributes as $attribute) {
            $functionName = $this->changeFunctionName($attribute);
            $value = $stringToSearch->$functionName();
            if (!empty($value)) {
                if ($sql == "") {
                    $sql = "(" . $attribute . " LIKE '%" . $stringToSearch->$functionName() . "%')";
                } else {
                    $sql = $sql . " AND (" . $attribute . " LIKE '%" . $stringToSearch->$functionName() . "%')";
                }
            }
        }
        return $sql;
    }
}
