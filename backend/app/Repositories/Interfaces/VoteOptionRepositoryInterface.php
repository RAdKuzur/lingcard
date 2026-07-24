<?php

namespace App\Repositories\Interfaces;

interface VoteOptionRepositoryInterface extends BaseRepositoryInterface
{
    public function findByVoteId($id);
}
