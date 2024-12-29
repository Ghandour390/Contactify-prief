<?php
class Connexion {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "crudtest";
    protected static $connexion;

    public static function connect() {
        if (!self::$connexion) {
            try {
                self::$connexion = new PDO(
                    "mysql:host=" . self::$servername . 
                    ";dbname=" . self::$dbname . 
                    ";charset=UTF8",
                    self::$username,
                    self::$password
                );
                self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$connexion;
    }
}

// Initialy connection
connexion::connect();