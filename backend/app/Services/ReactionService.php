<?php

namespace App\Services;

use App\Dictionaries\StatusReactionDictionary;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\ReactionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReactionService
{
    private ReactionRepositoryInterface $reactionRepository;
    private PostRepositoryInterface $postRepository;
    public function __construct(
        ReactionRepositoryInterface $reactionRepository,
        PostRepositoryInterface $postRepository
    )
    {
        $this->reactionRepository = $reactionRepository;
        $this->postRepository = $postRepository;
    }

    public function like($id)
    {
        DB::beginTransaction();
        try{
            $user = AuthHelper::user();
            $this->reactionRepository->deleteReaction($user->id, $id, StatusReactionDictionary::DISLIKE);
            $this->reactionRepository->insert([
                'user_id' => $user->id,
                'post_id' => $id,
                'status' => StatusReactionDictionary::LIKE
            ]);
            $this->postRepository->incrementLikesCount($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
    }
    public function dislike($id)
    {
        DB::beginTransaction();
        try{
            $user = AuthHelper::user();
            $this->reactionRepository->deleteReaction($user->id, $id, StatusReactionDictionary::LIKE);
            $this->reactionRepository->insert([
                'user_id' => $user->id,
                'post_id' => $id,
                'status' => StatusReactionDictionary::DISLIKE
            ]);
            $this->postRepository->incrementDislikesCount($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
    }

    public function unset($id)
    {
        DB::beginTransaction();
        try{
            $user = AuthHelper::user();
            $reaction = $this->reactionRepository->findReaction($user->id, $id);
            if ($reaction) {
                $this->reactionRepository->delete($reaction->id);
                if ($reaction->status == StatusReactionDictionary::LIKE) {
                    $this->postRepository->decrementLikesCount($id);
                }
                if ($reaction->status == StatusReactionDictionary::DISLIKE) {
                    $this->postRepository->decrementDislikesCount($id);
                }
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
    }
}
