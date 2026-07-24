<?php

namespace App\Services;

use App\DTO\SimpleVoteDTO;
use App\DTO\VoteDTO;
use App\Repositories\Interfaces\VoiceRepositoryInterface;
use App\Repositories\Interfaces\VoteOptionRepositoryInterface;
use App\Repositories\Interfaces\VoteRepositoryInterface;

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
                title: $vote->title
            ))->toArray();
        }
        return $data;
    }
    public function one($id) : array
    {
        $data = [];
        $count = 0;
        $vote = $this->voteRepository->find($id);
        $voteOptions = $this->voteOptionRepository->findByVoteId($id);
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
            voteOptions: $data,
            totalCount: $count,
            isActive: $vote->is_active
        ))->toArray();

    }
    public function vote($voteOptionId) {

    }
    public function cancelVote($voteOptionId) {

    }
}
