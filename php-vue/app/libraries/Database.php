<?php
/**
 * PDO Database Class
 */
class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $encoding = DB_ENCODING;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct($db) {
        if($db === 'mypage'){
            $this->host     = DB_HOST_MP;
            $this->user     = DB_USER_MP;
            $this->pass     = DB_PASS_MP;
            $this->dbname   = DB_NAME_MP;
        } else if($db === 'login'){
            $this->host     = DB_HOST_LG;
            $this->user     = DB_USER_LG;
            $this->pass     = DB_PASS_LG;
            $this->dbname   = DB_NAME_LG;
        }

        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';port=3306;dbname=' . $this->dbname . ';charset=' . $this->encoding;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create PDO instance
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Prepare statement with query
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind values
    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true){
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

    // Execute the prepared statement
    public function execute(){
        return $this->stmt->execute();
    }

    // Get result set as array of column
    public function resultCol(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Get result set as array
    public function resultArr(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get result set as array of objects
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount(){
        return $this->stmt->rowCount();
    }

    // Execute on WHERE IN clause
    public function execArr($arr){
        return $this->stmt->execute($arr);
    }

    public function debugSql(){
        return $this->stmt->debugDumpParams();
    }
}