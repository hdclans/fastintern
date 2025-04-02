<?php

namespace App\Database;

class Database {
    private $conn;
    
    public function __construct() {
        // Paramètres de connexion (à adapter selon votre configuration)
        $host = "98.66.137.152";
        $dbname = "fastintern";
        $username = "hugo3";
        $password = "Maison98!";
        
        try {
            $this->conn = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
            exit;
        }
    }
    
    public function getConnection() {
        return $this->conn;
    }
}