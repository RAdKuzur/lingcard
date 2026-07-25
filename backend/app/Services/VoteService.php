<?php

namespace App\Services;

use App\DTO\SimpleVoteDTO;
use App\DTO\VoteDTO;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Repositories\Interfaces\VoiceRepositoryInterface;
use App\Repositories\Interfaces\VoteOptionRepositoryInterface;
use App\Repositories\Interfaces\VoteRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VoteService
{
    private VoteRepositoryInterface $voteRepository;
    private VoteOptionRepositoryInterface $voteOptionRepository;
    private VoiceRepositoryInterface $voiceRepository;
    public function __construct(
        VoteRepositoryInterface $voteRepository,
        VoteOptionRepositoryInterface $voteOptionRepository,
        VoiceRepositoryInterface $voiceRepository
    )
    {
        $this->voteRepository = $voteRepository;
        $this->voteOptionRepository = $voteOptionRepository;
        $this->voiceRepository = $voiceRepository;

    }

    public function all()
    {
        $data = [];
        $votes = $this->voteRepository->all();
        foreach ($votes as $vote) {
            $data[] = (new SimpleVoteDTO(
                id: $vote->id,
                title: $vote->title,
                content: $vote->content,
            ))->toArray();
        }
        return $data;
    }
    public function one($id) : array
    {
        $data = [];
        $count = 0;
        $user = AuthHelper::user();
        $vote = $this->voteRepository->find($id);
        $voteOptions = $this->voteOptionRepository->findByVoteId($id);
        $voice = $this->voiceRepository->findUserVoices($user->id, array_column($voteOptions->toArray(), 'id'));
        foreach ($voteOptions as $voteOption) {
            $countVoices = $this->voiceRepository->countVoices($voteOption->id);
            $data[] = [
                'id' => $voteOption->id,
                'title' => $voteOption->title,
                'content' => $voteOption->content,
                'count' => $countVoices
            ];
            $count = $count + $countVoices;
        }

        return (new VoteDTO(
            id: $vote->id,
            title: $vote->title,
            content: $vote->content,
            voteOptions: $data,
            totalCount: $count,
            isActive: $vote->is_active,
            voted: $voice?->vote_option_id
        ))->toArray();

    }
    public function vote($voteOptionId) {
        DB::beginTransaction();
        try {
            $user = AuthHelper::user();
            $vote = $this->voteOptionRepository->find($voteOptionId);
            $voteOptions = $this->voteOptionRepository->findByVoteId($vote->vote_id);
            $this->voiceRepository->deleteUserVoices($user->id, array_column($voteOptions->toArray(), 'id'));
            $this->voiceRepository->insert([
                'vote_option_id' => $voteOptionId,
                'user_id' => $user->id,
                'time' => now()
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
    }
    public function cancelVote($voteOptionId) {
        DB::beginTransaction();
        try {
            $user = AuthHelper::user();
            $this->voiceRepository->deleteVoice($user->id, $voteOptionId);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
    }
}
