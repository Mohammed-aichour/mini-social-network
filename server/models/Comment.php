<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Comment {
    public static function create(int $postId, int $userId, string $content): int {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$postId, $userId, $content]);
        return (int)$db->lastInsertId();
    }

    public static function getByPostId(int $postId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT c.*, u.username, u.avatar_url 
            FROM comments c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.post_id = ? 
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    public static function delete(int $id, int $userId): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }
}
