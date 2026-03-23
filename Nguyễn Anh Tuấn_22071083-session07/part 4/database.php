<?php
    class Database {
        private static $instance = null;
        private $connection;

        private function __construct() {
            $servername = "127.0.0.1";
            $dbname = "test";
            $username = "root";
            $password = "";
            $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->connection = new PDO($dsn, $username, $password, $options);

        }

        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new Database();
            }
            return self::$instance;
        }

        public function getConnection() {
            return $this->connection;
        }
    }
?>