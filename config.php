<?php
    class config
    {
        public $siteurl="http://localhost/training/Task11-SQL-1/index.php";
        public $dbhost="localhost";
        public $dbuser="root";
        public $dbpass="";
        public $dbname="Cedcab";
        public $conn;
        
        function __construct(){
            $this->conn = new mysqli($this -> dbhost,$this -> dbuser,$this -> dbpass,$this -> dbname);
                if($this->conn -> connect_error){
                    die("connection failed: ".$this->conn -> connect_error);
                }
                // echo "connected successfully";

        }

    }
?>

