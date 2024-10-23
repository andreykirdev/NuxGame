<?php

namespace Database;
use PDO;

class DatabaseConnection {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new PDO('sqlite:' . __DIR__ . '/../../database.sqlite');
        $this->initialize();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    private function initialize() {
        $this->connection->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY,
            username TEXT,
            phone_number TEXT
        )");

        $this->connection->exec("CREATE TABLE IF NOT EXISTS unique_links (
            id INTEGER PRIMARY KEY,
            user_id INTEGER,
            link TEXT,
            active INTEGER DEFAULT 1,
            expires_at DATETIME
        )");

        $this->connection->exec("CREATE TABLE IF NOT EXISTS history (
            id INTEGER PRIMARY KEY,
            user_id INTEGER,
            result TEXT,
            win_amount REAL,
            created_at DATETIME
        )");
    }
}
