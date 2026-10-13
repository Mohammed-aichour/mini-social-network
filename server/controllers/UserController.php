<?php
namespace App\Controllers;

use App\Models\User;

class UserController {
    public static function show(int $userId): void {
        $user = User::findById($userId);
        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'User not found']);
            return;
        }
        echo json_encode(['success' => true, 'user' => $user]);
    }

    public static function update(array $currentUser): void {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $bio = $data['bio'] ?? null;
        $avatarUrl = $data['avatar_url'] ?? null;

        User::updateProfile($currentUser['user_id'], $bio, $avatarUrl);
        $updated = User::findById($currentUser['user_id']);

        echo json_encode(['success' => true, 'message' => 'Profile updated', 'user' => $updated]);
    }
}
