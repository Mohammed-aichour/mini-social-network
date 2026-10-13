<?php
/**
 * Authentication Middleware
 * Mini Social Network
 * Author: Mohammed AICHOUR
 */

namespace App\Middleware;

class AuthMiddleware {
    /**
     * Authenticates the incoming request using a Bearer token or session.
     * Returns the user payload if valid, or outputs 401 JSON and halts.
     */
    public static function authenticate(): array {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized: Missing or malformed Authorization header'
            ]);
            exit;
        }

        $token = $matches[1];
        
        // Mock / Simple JWT payload decoder for lightweight deployment
        $parts = explode('.', $token);
        if (count($parts) === 3) {
            $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
            if ($payload && isset($payload['user_id'])) {
                if (isset($payload['exp']) && $payload['exp'] < time()) {
                    http_response_code(401);
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Token has expired']);
                    exit;
                }
                return $payload;
            }
        }

        // For simple bearer tokens (e.g. session-based token token-userId-hash)
        if (str_starts_with($token, 'session_user_')) {
            $userId = (int)str_replace('session_user_', '', $token);
            if ($userId > 0) {
                return ['user_id' => $userId];
            }
        }

        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid authentication token']);
        exit;
    }
}
