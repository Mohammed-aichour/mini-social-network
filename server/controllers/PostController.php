<?php
namespace App\Controllers;

use App\Models\Post;

class PostController {
    public static function index(): void {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        $posts = Post::getFeed($limit, $offset);
        echo json_encode(['success' => true, 'posts' => $posts]);
    }

    public static function store(array $currentUser): void {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $content = trim($data['content'] ?? '');
        $imageUrl = $data['image_url'] ?? null;

        if (empty($content)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Post content cannot be empty']);
            return;
        }

        $postId = Post::create($currentUser['user_id'], $content, $imageUrl);
        $post = Post::findById($postId);

        echo json_encode(['success' => true, 'message' => 'Post published', 'post' => $post]);
    }

    public static function destroy(int $postId, array $currentUser): void {
        $deleted = Post::delete($postId, $currentUser['user_id']);
        if (!$deleted) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Cannot delete post: Not authorized or post not found']);
            return;
        }
        echo json_encode(['success' => true, 'message' => 'Post deleted successfully']);
    }
}
