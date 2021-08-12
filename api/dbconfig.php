<?php
header('Content-Type: application/json');
class Database
{
    private $pdo;

    public function __construct()
    {
        $host = "localhost";
        $dbname = "comsci";
        $username = "comsci";
        $password = "comsci64";

        $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $conn;
    }

    public function Read($sql)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
            return http_response_code(401);
        }

    }

    public function Create($sql)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return "Insert data successfully.";
        } catch (Exception $e) {
            echo $e->getMessage();
            return http_response_code(401);
        }
    }

    public function Update($sql)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return "Data updated.";
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public function Delete($sql)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return "Data deleted.";
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}
