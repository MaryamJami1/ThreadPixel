<?php
/**
 * ThreadPixel - Database Connection (SQLite Singleton for Local Testing)
 */

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // Path to the SQLite database file
        $dbFile = dirname(__DIR__, 2) . '/database/threadpixel.sqlite';
        
        $dsn = 'sqlite:' . $dbFile;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        try {
            $this->pdo = new PDO($dsn, null, null, $options);
            // Enable foreign keys for SQLite
            $this->pdo->exec('PRAGMA foreign_keys = ON;');
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }

    private function __clone() {}
}
