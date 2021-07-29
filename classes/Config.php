<?php
session_start();
class Config
{
    // localhost
    // private $servername ='localhost';
    // private $username = 'root';
    // private $password = '';
    // private $db_name = 'inventory_control_db';
    // public $conn;

    //heroku --ver1
    // private $servername ='eu-cdbr-west-01.cleardb.com';
    // private $username = 'b9b3c9447ad231';
    // private $password = '278ab5c8';
    // private $db_name = 'heroku_8b827418e2ccc6d';
    // public $conn;

    //heroku --ver2
    private $servername ='us-cdbr-east-04.cleardb.com';
    private $username = 'bbca1315152850';
    private $password = 'aa48e207';
    private $db_name = 'heroku_7bcd1e58d86e369';
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername,$this->username,$this->password,$this->db_name);

        return $this->conn;
    }

}

?>