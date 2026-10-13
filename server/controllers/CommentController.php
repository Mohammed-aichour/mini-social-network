<?php
namespace App\Controllers;

use App\Models\Comment;

class CommentController {
    public static function index(int $postId): void {
        $comments = Comment::getByPostId($postId);
        echo json_encode(['success' => true, 'comments' => $comments]);
    }

    public static function store(int $postId, array $currentUser): void {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $content = trim($data['content'] ?? '');

        if (empty($content)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Comment content cannot be empty']);
            return;
        }

        $id = Comment::create($postId, $currentUser['user_id'], $content);
        echo json_encode(['success' => true, 'comment_id' => $id, 'message' => 'Comment added']);
    }

    public static function destroy(int $commentId, array $currentUser): void {
        $deleted = Comment::delete($commentId, $currentUser['user_id']);
        if (!$deleted) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Cannot delete comment']);
            return;
        }
        echo json_encode(['success' => true, 'message' => 'Comment deleted']);
    }
}
