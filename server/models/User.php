<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class User {
    public static function create(string $username, string $email, string $password): int {
        $db = Database::getConnection();
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hash]);
        return (int)$db->lastInsertId();
    }

    public static function findByEmail(string $email): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public static function findById(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, username, email, avatar_url, bio, created_at FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public static function updateProfile(int $id, ?string $bio, ?string $avatarUrl): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE users SET bio = COALESCE(?, bio), avatar_url = COALESCE(?, avatar_url) WHERE id = ?");
        return $stmt->execute([$bio, $avatarUrl, $id]);
    }
}
