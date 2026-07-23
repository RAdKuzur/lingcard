<?php

namespace App\Services;

use App\Repositories\Interfaces\SuggestionRepositoryInterface;

class SuggestionService
{
    private SuggestionRepositoryInterface $suggestionRepository;
    public function __construct(
        SuggestionRepositoryInterface $suggestionRepository
    )
    {
        $this->suggestionRepository = $suggestionRepository;
    }
}
