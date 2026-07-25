<?php

namespace App\Repositories\Interfaces;

interface ReactionRepositoryInterface extends BaseRepositoryInterface
{
    public function findReaction($userId, $postId);
    public function deleteReaction($userId, $postId, $status);
    public function isLiked($userId, $postId) : bool;
    public function isDisliked($userId, $postId) : bool;
    public function countLikes($postId);
    public function countDislikes($postId);
}
