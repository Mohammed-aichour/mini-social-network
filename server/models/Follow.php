<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Follow {
    public static function toggle(int $followerId, int $followingId): bool {
        if ($followerId === $followingId) return false;
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT id FROM follows WHERE follower_id = ? AND following_id = ?");
        $stmt->execute([$followerId, $followingId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $del = $db->prepare("DELETE FROM follows WHERE follower_id = ? AND following_id = ?");
            $del->execute([$followerId, $followingId]);
            return false; // un-followed
        } else {
            $ins = $db->prepare("INSERT INTO follows (follower_id, following_id) VALUES (?, ?)");
            $ins->execute([$followerId, $followingId]);
            return true; // followed
        }
    }

    public static function isFollowing(int $followerId, int $followingId): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id FROM follows WHERE follower_id = ? AND following_id = ?");
        $stmt->execute([$followerId, $followingId]);
        return (bool)$stmt->fetch();
    }
}
