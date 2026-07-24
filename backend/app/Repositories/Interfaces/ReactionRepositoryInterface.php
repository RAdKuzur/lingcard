<?php

namespace App\Repositories\Interfaces;

interface ReactionRepositoryInterface extends BaseRepositoryInterface
{
    public function findReaction($userId, $newsId);
    public function deleteReaction($userId, $newsId, $status);
    public function isLiked($userId, $newsId) : bool;
    public function isDisliked($userId, $newsId) : bool;
    public function countLikes($newsId);
    public function countDislikes($newsId);
}
