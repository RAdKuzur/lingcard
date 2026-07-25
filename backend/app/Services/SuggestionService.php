<?php

namespace App\Services;

use App\DTO\SuggestionDTO;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Repositories\Interfaces\SuggestionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SuggestionService
{
    private SuggestionRepositoryInterface $suggestionRepository;
    public function __construct(
        SuggestionRepositoryInterface $suggestionRepository
    )
    {
        $this->suggestionRepository = $suggestionRepository;
    }

    public function create(SuggestionDTO $suggestionDTO) {
        DB::beginTransaction();
        try{
            $user = AuthHelper::user();
            $this->suggestionRepository->insert([
                'user_id' => $user->id,
                'message' => $suggestionDTO->message,
                'date' => now(),
                'status' => false
            ]);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
    }
}
