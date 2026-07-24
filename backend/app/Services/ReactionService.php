<?php

namespace App\Services;

use App\Dictionaries\StatusReactionDictionary;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Repositories\Interfaces\ReactionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReactionService
{
    private ReactionRepositoryInterface $reactionRepository;
    private NewsRepositoryInterface $newsRepository;
    public function __construct(
        ReactionRepositoryInterface $reactionRepository,
        NewsRepositoryInterface $newsRepository
    )
    {
        $this->reactionRepository = $reactionRepository;
        $this->newsRepository = $newsRepository;
    }

    public function like($id)
    {
        DB::beginTransaction();
        try{
            $user = AuthHelper::user();
            $this->reactionRepository->deleteReaction($user->id, $id, StatusReactionDictionary::DISLIKE);
            $this->reactionRepository->insert([
                'user_id' => $user->id,
                'news_id' => $id,
                'status' => StatusReactionDictionary::LIKE
            ]);
            $this->newsRepository->incrementLikesCount($id);
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
                'news_id' => $id,
                'status' => StatusReactionDictionary::DISLIKE
            ]);
            $this->newsRepository->incrementDislikesCount($id);
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
                    $this->newsRepository->decrementLikesCount($id);
                }
                if ($reaction->status == StatusReactionDictionary::DISLIKE) {
                    $this->newsRepository->decrementDislikesCount($id);
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
