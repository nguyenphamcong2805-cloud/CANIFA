<?php

class Database
{
    private $host = "localhost";
    private $dbname = "canifashop";
    private $username = "root";
    private $password = "";

    private $conn;

    public function __construct()
    {
        $this->conn = null;
    }

    public function getConnection()
    {
        if ($this->conn === null) {

            try {

                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

                $this->conn = new PDO(
                    $dsn,
                    $this->username,
                    $this->password,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false
                    ]
                );

            } catch (PDOException $e) {

                die("Kết nối CSDL thất bại: " . $e->getMessage());

            }

        }

        return $this->conn;
    }
}