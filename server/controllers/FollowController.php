<?php
namespace App\Controllers;

use App\Models\Follow;

class FollowController {
    public static function toggle(int $targetUserId, array $currentUser): void {
        if ($targetUserId === $currentUser['user_id']) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Cannot follow yourself']);
            return;
        }

        $following = Follow::toggle($currentUser['user_id'], $targetUserId);
        echo json_encode([
            'success' => true,
            'following' => $following,
            'message' => $following ? 'Followed successfully' : 'Unfollowed successfully'
        ]);
    }
}
