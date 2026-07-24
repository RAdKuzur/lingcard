<?php

namespace App\Repositories\Interfaces;

interface VoiceRepositoryInterface extends BaseRepositoryInterface
{
    public function countVoices($voteOptionId) : int;
    public function deleteVoice($userId, $voteOptionId);
    public function deleteUserVoices($userId, array $voteOptionIds);
    public function findUserVoices($userId, array $voteOptionIds) ;
}
