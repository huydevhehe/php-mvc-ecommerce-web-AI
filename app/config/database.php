<?php
class Database {
    private $host = "localhost";
    private $db_name = "my_store";
    private $username = "root";
    private $password = "";
    private $conn;

    // Instance method
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    // Static method cho các model
    public static function connect() {
        try {
            $pdo = new PDO(
                "mysql:host=localhost;dbname=my_store",
                "root",
                ""
            );
            $pdo->exec("set names utf8");
            return $pdo;
        } catch (PDOException $e) {
            die("Connection error (static): " . $e->getMessage());
        }
    }
}
