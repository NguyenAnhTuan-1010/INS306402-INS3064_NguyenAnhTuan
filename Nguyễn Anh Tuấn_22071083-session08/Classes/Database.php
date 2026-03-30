<?php
// namespace App\Database; // Thêm namespace nếu cần

/**
 * Database Wrapper Class using Singleton Pattern
 * Provides a secure and consistent interface for PDO interactions.
 */
class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    /**
     * Private constructor to prevent direct instantiation.
     * Loads configuration and establishes a secure PDO connection.
     */
    private function __construct()
    {
        // Path to your database configuration file
        $config = require __DIR__ . '/../config/database.php';

        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Return associative arrays
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
            ]);
        } catch (PDOException $e) {
            // Logs detailed error for developers
            error_log("Connection Error: " . $e->getMessage());
            // Throws user-friendly message
            throw new Exception("Unable to connect to the database. Please try again later.");
        }
    }

    /**
     * Returns the single instance of the Database class.
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Direct access to the underlying PDO object.
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    /**
     * Prepares and executes an SQL query with optional parameters.
     */
    public function query(string $sql, array $params = []): PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params); // Safeguards against SQL Injection
            return $stmt;
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage() . " | SQL: " . $sql);
            throw new Exception("A database error occurred during the operation.");
        }
    }

    /**
     * Fetches all records matching the query.
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Fetches a single record or returns false if not found.
     */
    public function fetch(string $sql, array $params = []): array|false
    {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Inserts a record into a table and returns the last inserted ID.
     */
    public function insert(string $table, array $data): string
    {
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
        $this->query($sql, array_values($data));

        return $this->pdo->lastInsertId();
    }

    /**
     * Updates records and returns the number of affected rows.
     */
    public function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $fields = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE {$table} SET {$fields} WHERE {$where}";
        
        $combinedParams = array_merge(array_values($data), $whereParams);
        return $this->query($sql, $combinedParams)->rowCount();
    }

    /**
     * Deletes records and returns the number of affected rows.
     */
    public function delete(string $table, string $where, array $params = []): int
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        return $this->query($sql, $params)->rowCount();
    }
}