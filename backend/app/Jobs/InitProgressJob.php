<?php

namespace App\Jobs;

use App\Dictionaries\StatusDictionary;
use App\Helpers\AuthHelper;
use App\Models\User;
use App\Repositories\WordTranslationRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class InitProgressJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    private $baseLanguageId;
    private $targetLanguageId;
    private $userId;
    public function __construct(
        int $baseLanguageId,
        int $targetLanguageId,
        int $userId
    )
    {
        $this->baseLanguageId = $baseLanguageId;
        $this->targetLanguageId = $targetLanguageId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $wordTranslations = (new WordTranslationRepository())->getByTargetLanguageIdAndBaseLanguageId($this->baseLanguageId, $this->targetLanguageId);
            foreach ($wordTranslations as $wordTranslation) {
                DB::table('courses')->insert([
                    'word_translation_id' => $wordTranslation->translation_id,
                    'repeat' => 0,
                    'status' => StatusDictionary::NONE,
                    'user_id' => $this->userId,
                    'last_time_repeated' => now()
                ]);
            }
        }
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }
}
