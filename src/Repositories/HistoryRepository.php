<?php

namespace Repositories;

use Database\DatabaseConnection;
use PDO;

class HistoryRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = DatabaseConnection::getInstance()->getConnection();
    }

    public function addLuckyResult($userId, $luckyResult, $createdAt) {
        $result = $luckyResult['result'];
        $winAmount = $luckyResult['winAmount'];
        $stmt = $this->pdo->prepare("INSERT INTO history (user_id, result, win_amount, created_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $result, $winAmount, $createdAt]);
    }

    public function getHistory($userId) {
        $stmt = $this->pdo->prepare("
        SELECT * FROM history 
        WHERE user_id = ? 
        ORDER BY created_at DESC 
        LIMIT 3
    ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
