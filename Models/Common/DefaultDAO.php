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
            $function_name = $this->changeFunctionName($attribute);
            $value = $entity->$function_name();

            if(is_object($value)) {
                $attribute = $attribute . "_id";
                $value = $value->getId();
            }

            if ($sql_keys == "") {
                $sql_keys = "(" . $attribute;
            } else {
                $sql_keys = $sql_keys . "," . $attribute;
            }

            $value = $this->checkValueType($value);

            if ($sql_values == "") {
                $sql_values = "(" . $value;
            } else {
                $sql_values = $sql_values . ", " . $value;
            }
        }

        $primary_key_function = $this->changeFunctionName($primary_key);

        $sql = "SELECT * FROM " . $this->getTableName($entity) . " WHERE " . $primary_key . "='".
            $entity->$primary_key_function() . "'";
        if (!$result = $this->mysqli->query($sql)){
            throw new DAOException('Error de conexión con la base de datos.');
        }
        else {
            if ($result->num_rows == 0){
                $sql = "INSERT INTO " . $this->getTableName($entity) . $sql_keys . ") VALUES " . $sql_values . ")";
                if(!$resultInsertion = $this->mysqli->query($sql)) {
                    throw new DAOException('Error de la base de datos: %' .
                        str_replace("\'", "", addslashes($this->mysqli->error)) . '%');
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

            if(is_object($value)) {
                $attribute = $attribute . "_id";
                $value = $value->getId();
            }

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
        $sql_query = "SELECT * FROM " . $this->getTableName($entity) . " WHERE " . $primary_key . "= '" .
            $entity->$primary_key_function() . "'";

        if (!$result = $this->mysqli->query($sql_query)) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            if ($result->num_rows != 0) {
                $sql_edit = "UPDATE " . $this->getTableName($entity) . " SET " . $sql . " WHERE " .
                    $primary_key . "= '" . $entity->$primary_key_function() . "'";
                if(!$resultEdit = $this->mysqli->query($sql_edit)) {
                    throw new DAOException('Error de la base de datos: %' .
                        str_replace("\'", "", addslashes($this->mysqli->error)) . '%');
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
<<<<<<< HEAD
        $sql = "SELECT COUNT(*) FROM " . strtoupper(get_class($entity));
=======
        $sql = "SELECT COUNT(*) FROM " . $this->getTableName($entity);
>>>>>>> Adds IT1_F2_A2 - Academic courses management
        $sql .= $this->obtainWhereClauseToSearch($entity, $stringToSearch);
        if (!($result = $this->mysqli->query($sql))) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            return $result->fetch_row()[0];
        }
    }

<<<<<<< HEAD
    function showAllPaged($currentPage, $itemsPerPage, $entity, $stringToSearch) {
        $startBlock = ($currentPage - 1) * $itemsPerPage;
        $sql = "SELECT * FROM " . strtoupper(get_class($entity));
=======
    function checkDependencies($tableName, $value) {
        $sql = "SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE REFERENCED_TABLE_NAME = '" . strtoupper($tableName) . "'";
        $dependencies = $this->getArrayFromSqlQuery($sql);
        $stringToShow = "";

        foreach ($dependencies as $dependency) {
            $tableDependency = $dependency["TABLE_NAME"];
            $columnDependency = $dependency["COLUMN_NAME"];
            $sql_dependencies = "SELECT * FROM " . $tableDependency . " WHERE " . $columnDependency . " = '" . $value . "'";
            $dependency_array = $this->getArrayFromSqlQuery($sql_dependencies);
            if(!empty($dependency_array)) {
                if($stringToShow == "") {
                    $stringToShow .= "No se puede borrar por que hay %" . count($dependency_array) . "% elementos en %" . $tableDependency .
                        "%";
                } else {
                    $stringToShow .= " y %" . count($dependency_array) . "% elementos en %" . $tableDependency .
                        "%";
                }

                $stringToShow .= " que dependen de esta entidad.";

                throw new DAOException($stringToShow);
            }
        }
    }

    function showAllPaged($currentPage, $itemsPerPage, $entity, $stringToSearch) {
        $startBlock = ($currentPage - 1) * $itemsPerPage;
        $sql = "SELECT * FROM " . $this->getTableName($entity);
>>>>>>> Adds IT1_F2_A2 - Academic courses management
        $sql .= $this->obtainWhereClauseToSearch($entity, $stringToSearch);
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

<<<<<<< HEAD
=======
    private function obtainWhereClauseToSearch($entity, $stringToSearch) {
        $sql = "";
        if(get_class($stringToSearch) == "DefaultDAO" || empty(get_class($stringToSearch))) {
            if (!is_null($stringToSearch)) {
                $sqlWhere = $this->getSearchConsult($entity, $stringToSearch);
                $sql = " WHERE " . $sqlWhere;
            }
        } else {
            $sqlWhere = $this->getSearchConsultWithEntity($stringToSearch);
            $sql = " WHERE " . $sqlWhere;
        }
        return $sql;
    }

>>>>>>> Adds IT1_F2_A2 - Academic courses management
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
<<<<<<< HEAD
                if ($sql == "") {
                    $sql = "(" . $attribute . " LIKE '%" . $stringToSearch->$functionName() . "%')";
                } else {
                    $sql = $sql . " AND (" . $attribute . " LIKE '%" . $stringToSearch->$functionName() . "%')";
=======
                if(!is_object($value)) {
                    if ($sql == "") {
                        $sql = "(" . $attribute . " LIKE '%" . $value . "%')";
                    } else {
                        $sql = $sql . " AND (" . $attribute . " LIKE '%" . $value . "%')";
                    }
                } else {
                    $attribute = $attribute . "_id";
                    if ($sql == "") {
                        $sql = "(" . $attribute . " = '" . $value->getId() . "')";
                    } else {
                        $sql = $sql . " AND (" . $attribute . " = '" . $value->getId() . "')";
                    }
>>>>>>> Adds IT1_F2_A2 - Academic courses management
                }
            }
        }
        return $sql;
    }

<<<<<<< HEAD
    private function obtainWhereClauseToSearch($entity, $stringToSearch) {
        $sql = "";
        if(get_class($stringToSearch) == "DefaultDAO" || empty(get_class($stringToSearch))) {
            if (!is_null($stringToSearch)) {
                $sqlWhere = $this->getSearchConsult($entity, $stringToSearch);
                $sql = " WHERE " . $sqlWhere;
            }
        } else {
            $sqlWhere = $this->getSearchConsultWithEntity($stringToSearch);
            $sql = " WHERE " . $sqlWhere;
        }
        return $sql;
=======
    private function getTableName($entity) {
        return strtoupper(preg_replace('/\B([A-Z])/', '_$1', get_class($entity)));
>>>>>>> Adds IT1_F2_A2 - Academic courses management
    }
}
