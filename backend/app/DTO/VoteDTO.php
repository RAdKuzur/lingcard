<?php

namespace App\DTO;

class VoteDTO implements BaseDTO
{
    public ?int $id = null;
    public ?string $title = null;
    public ?array $voteOptions = [];
    public ?int $totalCount = null;
    public ?bool $isActive = null;
    public ?int $voted = null;
    public function __construct(
        ?int $id = null,
        ?string $title = null,
        ?array $voteOptions = [],
        ?int $totalCount = null,
        ?bool $isActive = null,
        ?int $voted = null
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->voteOptions = $voteOptions;
        $this->totalCount = $totalCount;
        $this->isActive = $isActive;
        $this->voted = $voted;
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'vote_options' => $this->voteOptions,
            'total_count' => $this->totalCount,
            'is_active' => $this->isActive,
            'voted' => $this->voted
        ];
    }
}
