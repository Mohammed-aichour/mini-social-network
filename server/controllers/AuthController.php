<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    public static function register(): void {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $username = trim($data['username'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if (strlen($username) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid registration parameters (username >= 3, valid email, password >= 6)']);
            return;
        }

        if (User::findByEmail($email)) {
            http_response_code(409);
            echo json_encode(['success' => false, 'message' => 'Email is already registered']);
            return;
        }

        $userId = User::create($username, $email, $password);
        $token = 'session_user_' . $userId;

        echo json_encode([
            'success' => true,
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => ['id' => $userId, 'username' => $username, 'email' => $email]
        ]);
    }

    public static function login(): void {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
            return;
        }

        $token = 'session_user_' . $user['id'];

        echo json_encode([
            'success' => true,
            'message' => 'Authentication successful',
            'token' => $token,
            'user' => [
                'id' => (int)$user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'avatar_url' => $user['avatar_url']
            ]
        ]);
    }

    public static function me(array $currentUser): void {
        $user = User::findById($currentUser['user_id']);
        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'User not found']);
            return;
        }
        echo json_encode(['success' => true, 'user' => $user]);
    }
}
