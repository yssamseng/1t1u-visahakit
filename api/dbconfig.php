<?php
    
    class Database {
        private $pdo;

        public function __construct($host, $dbname, $username, $password){
            $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $conn;
        }

        public function query($show){
            $stmt = $this->pdo->prepare($show);
            $stmt->execute();

            if($show){
                $data = $stmt->fetchAll();
                return $data;
            }
        }
    }

?>