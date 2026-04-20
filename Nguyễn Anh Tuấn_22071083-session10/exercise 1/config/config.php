<?php
    class Database {
        private static $instance = null;
        private $connection;

        public function __construct(): void {
            $ip = "127.0.0.1";
            $dbname = "test";
            $port = 3306;
            $username = "root";
            $password = "";
            $dsn = "mysql:host=$ip;dbname=$dbname;charset=utf8mb4";
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