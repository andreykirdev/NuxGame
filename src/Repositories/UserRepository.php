<?php

namespace Repositories;

use Database\DatabaseConnection;

class UserRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = DatabaseConnection::getInstance()->getConnection();
    }

    public function createUser($username, $phoneNumber) {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, phone_number) VALUES (?, ?)");
        $stmt->execute([$username, $phoneNumber]);
        return $this->pdo->lastInsertId();
    }
}
