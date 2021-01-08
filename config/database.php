<?php
/**
 * Created by PhpStorm.
 * User: emon
 * Date: 11/22/19
 * Time: 10:16 PM
 */

class Database{
    private $host = 'localhost';
    private $db_name = 'loginscript';
    private $username = 'root';
    private $password = '';
    public $conn;

    //get the database connection

    public function getConnection(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name,$this->username,$this->password);

        }
        catch (PDOException $exception){
            echo "Connection Error:".$exception.getMessage();
        }

        return $this->conn;
    }
}