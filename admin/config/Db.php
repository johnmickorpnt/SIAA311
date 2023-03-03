<?php
class Db{
    private $host;
    private $user;
    private $password;
    private $dbname;
    private $conn;

    function __construct(){
        $this->host = 'localhost';
        $this->user = 'root';
        $this->password = '';
        $this->dbname = 'hubzbistro';
    }

    function connect(){
        $this->conn = null;

        try{
            $dsn = 'mysql:host=' . $this->get_host() . ';dbname=' . $this->get_dbname();
            $this->conn = new PDO($dsn, $this->get_user(), $this->get_password());
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            echo "Connection error: {$e}";
        }

        return $this->conn;
    }


    // GETTERS AND SETTERS
    function set_host($host){
        $this->host = $host;
    }

    function set_user($user){
        $this->user = $user;
    }

    function set_passwrod($password){
        $this->password = $password;
    }

    function set_dbname($dbname){
        $this->dbname = $dbname;
    }

    function get_host(){
        return $this->host;
    }

    function get_user(){
        return $this->user;
    }

    function get_password(){
        return $this->password;
    }

    function get_dbname(){
        return $this->dbname;
    }

}