<?php

namespace Repositories;

use Database\DatabaseConnection;

class UniqueLinkRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = DatabaseConnection::getInstance()->getConnection();
    }

    public function createUniqueLink($userId, $link, $expiresAt) {
        $stmt = $this->pdo->prepare("INSERT INTO unique_links (user_id, link, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $link, $expiresAt]);
    }

    public function findValidLink($link) {
        $stmt = $this->pdo->prepare("SELECT * FROM unique_links WHERE link = ? AND active = 1 AND expires_at > datetime('now')");
        $stmt->execute([$link]);
        return $stmt->fetch();
    }

    public function deleteLink($link) {
        $stmt = $this->pdo->prepare("DELETE FROM unique_links WHERE link = ?");
        $stmt->execute([$link]);
    }
}
