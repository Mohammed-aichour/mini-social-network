<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Post {
    public static function create(int $userId, string $content, ?string $imageUrl = null): int {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO posts (user_id, content, image_url) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $content, $imageUrl]);
        return (int)$db->lastInsertId();
    }

    public static function getFeed(int $limit = 20, int $offset = 0): array {
        $db = Database::getConnection();
        $sql = "SELECT p.id, p.user_id, p.content, p.image_url, p.created_at,
                       u.username, u.avatar_url,
                       (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.id) AS likes_count,
                       (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comments_count
                FROM posts p
                JOIN users u ON p.user_id = u.id
                ORDER BY p.created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT p.*, u.username, u.avatar_url FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public static function delete(int $id, int $userId): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }
}
