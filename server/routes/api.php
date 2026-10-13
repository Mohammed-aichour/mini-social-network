<?php
/**
 * RESTful API Router
 * Mini Social Network
 * Author: Mohammed AICHOUR
 */

use App\Controllers\AuthController;
use App\Controllers\PostController;
use App\Controllers\CommentController;
use App\Controllers\UserController;
use App\Controllers\FollowController;
use App\Middleware\AuthMiddleware;

return function (string $method, string $path) {
    // Healthcheck
    if ($method === 'GET' && ($path === '/api/health' || $path === '/api')) {
        echo json_encode([
            'status' => 'online',
            'project' => 'Mini Social Network REST API',
            'author' => 'Mohammed AICHOUR',
            'version' => '1.0.0'
        ]);
        return;
    }

    // Auth Routes
    if ($method === 'POST' && $path === '/api/auth/register') {
        AuthController::register();
        return;
    }

    if ($method === 'POST' && $path === '/api/auth/login') {
        AuthController::login();
        return;
    }

    if ($method === 'GET' && $path === '/api/auth/me') {
        $user = AuthMiddleware::authenticate();
        AuthController::me($user);
        return;
    }

    // Post Routes
    if ($method === 'GET' && $path === '/api/posts') {
        PostController::index();
        return;
    }

    if ($method === 'POST' && $path === '/api/posts') {
        $user = AuthMiddleware::authenticate();
        PostController::store($user);
        return;
    }

    if ($method === 'DELETE' && preg_match('#^/api/posts/(\d+)$#', $path, $m)) {
        $user = AuthMiddleware::authenticate();
        PostController::destroy((int)$m[1], $user);
        return;
    }

    // Comments Routes
    if ($method === 'GET' && preg_match('#^/api/posts/(\d+)/comments$#', $path, $m)) {
        CommentController::index((int)$m[1]);
        return;
    }

    if ($method === 'POST' && preg_match('#^/api/posts/(\d+)/comments$#', $path, $m)) {
        $user = AuthMiddleware::authenticate();
        CommentController::store((int)$m[1], $user);
        return;
    }

    if ($method === 'DELETE' && preg_match('#^/api/comments/(\d+)$#', $path, $m)) {
        $user = AuthMiddleware::authenticate();
        CommentController::destroy((int)$m[1], $user);
        return;
    }

    // User & Follow Routes
    if ($method === 'GET' && preg_match('#^/api/users/(\d+)$#', $path, $m)) {
        UserController::show((int)$m[1]);
        return;
    }

    if ($method === 'PUT' && $path === '/api/users/profile') {
        $user = AuthMiddleware::authenticate();
        UserController::update($user);
        return;
    }

    if ($method === 'POST' && preg_match('#^/api/users/(\d+)/follow$#', $path, $m)) {
        $user = AuthMiddleware::authenticate();
        FollowController::toggle((int)$m[1], $user);
        return;
    }

    // 404 Route Not Found
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Endpoint not found', 'path' => $path]);
};
