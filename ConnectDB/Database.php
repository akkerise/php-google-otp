<?php
session_start();

class Database extends PDO
{
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_DBNAME;
    private $dbdbms = DB_DBMS;

    private $_db;
    private $stmt;
    private $error;

    public function __construct()
    {
        if ($this->dbdbms === 'postgres') {
            $dsn = 'pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname;
        }
        $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname;
        $options = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        try {
            $this->_db = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->error = $e->getMessage();
        }
    }

    // create Database Name
    public function createDatabaseName($nameDatabase)
    {
        $sql = "CREATE DATABASE $nameDatabase CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        $this->query($sql);
        try {
            $res = $this->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
        if ($res === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // Create Table Postgres
    public function createTablesPostgres($tableName)
    {
        $sql = "CREATE TABLE $tableName(
            id integer NOT NULL DEFAULT nextval('users_id_seq'::regclass),
            customerid CHARACTER VARYING,
            firstname CHARACTER VARYING,
            lastname CHARACTER VARYING,
            email CHARACTER VARYING,
            token CHARACTER VARYING,
            street CHARACTER VARYING,
            city CHARACTER VARYING,
            state CHARACTER VARYING,
            postalcode CHARACTER VARYING,
            country CHARACTER VARYING,
            phonenumber CHARACTER VARYING,
            callback CHARACTER VARYING,
            informations JSONB,
            created_at TIMESTAMP DEFAULT(NOW()),
            updated_at TIMESTAMP DEFAULT(NOW())
        )";
        $this->query($sql);
        try {
            $this->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
        return true;
    }


    // Check Table Name Exists
    public function checkExistsTable($tableName)
    {
        $sql = "SELECT 1 FROM $tableName LIMIT 1";
        $this->query($sql);
        try {
            $res = $this->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
        if ($res === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Create Table MySQL
    public function createTablesMySQL($tableName)
    {
        $sql = "CREATE TABLE $tableName(
            id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
            customerid VARCHAR(255),
            firstname VARCHAR(255),
            lastname VARCHAR(255),
            email VARCHAR(255),
            token VARCHAR(255),
            street VARCHAR(255),
            city VARCHAR(255),
            state VARCHAR(255),
            postalcode VARCHAR(255),
            country VARCHAR(255),
            phonenumber VARCHAR(255),
            callback VARCHAR(255),
            informations TEXT(1000),
            updated_at DATETIME,
            created_at DATETIME)";
        $this->query($sql);
        try {
            $this->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
        return true;
    }

    public function query($sql)
    {
        $this->stmt = $this->_db->prepare($sql);
    }

    public function bind($params_arr)
    {
        foreach ($params_arr as $param => $value) {
            $type = isset($p['type']) ? $p['type'] : NULL;

            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;

                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function findAll()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOne()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId($seq_name = null)
    {
        return $this->_db->lastInsertId($seq_name);
    }

    public function convertKeysArrayToLower($data)
    {
        $keysData = array_keys($data);
        $valsData = array_values($data);
        for ($i = 0; $i < count($keysData); $i++) {
            if ($keysData[$i] === 'id') {
                $keysData[$i] = 'customerid';
            }
        }
        for ($i = 0; $i < count($keysData); $i++) {
            $newData[$keysData[$i]] = $valsData[$i];
        }
        return $newData;
    }

    /**
     * @param $tableName
     * @param $data
     * @return bool
     */
    public function insert($tableName, $data)
    {
        $fields = array_keys($data);
        for ($i = 0; $i < count($fields); $i++) {
            strtolower($fields[$i]);
        }
        $params = ':' . implode(',:', $fields);
        $fields = implode(',', $fields);
        $sql = "INSERT INTO $tableName ($fields) VALUES ($params)";
        $this->query($sql);
        $data = $this->renameKey($data, ':');
        $this->bind($data);
        try {
            $this->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }

    /**
     * @param $tableName
     * @param $data
     * @param $where
     * @return bool
     */
    public function update($tableName, $data, $where)
    {
        $fields = array_keys($data);
        $fields2 = array_keys($where);
        $query = $this->createQuery($fields);
        $condition = $this->createCondition($fields2);
        $sql = "UPDATE $tableName SET $query WHERE $condition";
        $this->query($sql);
        $data = $this->renameKey($data, ':');
        $where = $this->renameKey($where, ':_');
        $this->bind($data);
        $this->bind($where);
        try {
            $this->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }

    /**
     * @param $tableName
     * @param $where
     * @return bool
     */
    public function delete($tableName, $where)
    {
        $condition = $this->createConditionOR($where);
        $sql = "DELETE FROM $tableName WHERE $condition";
        $this->query($sql);
        $where = $this->renameKey($where, ':_');
        $this->bind($where);
        try {
            $this->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }

    private function createQuery($fields)
    {
        $query = [];
        for ($i = 0; $i < count($fields); $i++) {
            $query[] = $fields[$i] . '=:' . $fields[$i];
        }
        return implode(',', $query);
    }

    private function createCondition($fields)
    {
        $query = [];
        for ($i = 0; $i < count($fields); $i++) {
            $query[] = $fields[$i] . '=:_' . $fields[$i];
        }
        return implode(',', $query);
    }

    private function createConditionOR($fields)
    {
        // Array $fields remove $k have $v == NULL or $v == ''
        foreach ($fields as $k => $v) {
            if ($v != NULL || $v != '') {
                $arr[$k] = $v;
            }
        }
        $arr = array_keys($arr);
        $query = [];
        for ($i = 0; $i < count($arr); $i++) {
            $query[] = $arr[$i] . '=:_' . $arr[$i];
        }
        return implode(' OR ', $query);
    }

    private function renameKey($arr, $prefix)
    {
        foreach ($arr as $key => $value) {
            $arr[$prefix . $key] = $value;
            unset($arr[$key]);
        }
        return $arr;
    }

    // SELECT * FROM $tableName WHERE username=:username;
    public function login($tableName, $data)
    {
        $where['username'] = $data['username'];
        $params = array_keys($where);
        $query = $this->createQuery($params);
        $sql = "SELECT * FROM $tableName WHERE ($query)";
        $where = $this->renameKey($where, ':');
        $this->query($sql);
        $this->bind($where);
        try {
            $result = $this->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        if ($result !== true) {
            echo "<pre>";
            var_dump($result);
            echo "</pre>";
            die();
        } else {
            $dataRetrieve = $this->findOne();
//             check password
            if (password_verify($data['password'], $dataRetrieve['password'])) {
                return $dataRetrieve;
            } else {
                echo "<pre>";
                var_dump('Password not valid !');
                echo "</pre>";
                die();
            }
        }
    }


    // INSERT INTO abcabc (username, firstname, lastname, email, address, created_at)
    // VALUES (:username, :firstname, :lastname, :email, :address, :created_at)
    public function register($tableName, $data)
    {
        $fields = array_keys($data);
        $params = ':' . implode(',:', $fields);
        $fields = implode(',', $fields);
        $sql = "INSERT INTO $tableName ($fields) VALUES ($params)";
        $this->query($sql);
        $dataArr = $this->renameKey($data, ':');
        $this->bind($dataArr);
        try {
            $this->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return true;
    }

    public function checkExistsUser($tableName, $id)
    {
        $fields[':id'] = $id;
        $where = 'id=:id';
        $sql = "SELECT * FROM $tableName WHERE $where";
        $this->query($sql);
        $this->bind($fields);
        try {
            $this->execute();
        } catch (PDOException $e) {
            echo "<pre>";var_dump('Message: ' . $e->getMessage() . ' .Code: ' . $e->getCode() . ' .Line: ' . $e->getLine());echo "</pre>";die();
        }
        return $this->findOne();
    }

}

