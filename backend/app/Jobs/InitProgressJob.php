<?php

namespace App\Jobs;

use App\Dictionaries\StatusWordDictionary;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
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
        DB::beginTransaction();
        try {
            $wordTranslations = (new WordTranslationRepository())->getByTargetLanguageIdAndBaseLanguageId($this->baseLanguageId, $this->targetLanguageId);
            $insertData = [];
            foreach ($wordTranslations as $index => $wordTranslation) {
                $insertData[] = [
                    'word_translation_id' => $wordTranslation->translation_id,
                    'repeat' => 0,
                    'status' => StatusWordDictionary::NONE,
                    'user_id' => $this->userId,
                    'last_time_repeated' => now()
                ];
                if (!empty($insertData) && $index % 500 === 0) {
                    DB::table('courses')->insert($insertData);
                    DB::commit();
                    $insertData = [];
                }
            }
            if (!empty($insertData)) {
                DB::table('courses')->insert($insertData);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
            throw $e;
        }
    }
}
