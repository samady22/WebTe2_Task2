<?php


class Database
{
    private $conn;
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new mysqli("localhost", "username", "web2hikmat2023", "food_api");
            // Check connection
        } catch (Exception $exception) {
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
