<?php
class Database {
    private $host = "localhost";
    private $db_name = "jugadores";
    private $username = "phpmyadmin";
    private $password = "admin";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo json_encode(array("message" => "Error de conexión: " . $exception->getMessage()));
        }

        return $this->conn;
    }
}
