<?php
class Database {
    private static $pdo;

    private function __construct() {}

    public static function getConnection() {
        if (!self::$pdo) {
            $host = '127.0.0.1';
            $dbname = 'to-do_list';
            $username = 'admin';
            $password = 'admin';

            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro ao conectar: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
