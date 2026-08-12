<?php

namespace App\Services;

use App\Dictionaries\LevelDictionary;
use App\Dictionaries\StatusWordDictionary;
use App\DTO\WordProgressDTO;
use App\DTO\WordTrainingDTO;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Helpers\RepeatHelper;
use App\Jobs\InitProgressJob;
use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\WordTranslationRepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\DB;

class CourseService
{
    private CourseRepositoryInterface $courseRepository;
    private WordTranslationRepositoryInterface $wordTranslationRepository;
    public function __construct(
        CourseRepositoryInterface $courseRepository,
        WordTranslationRepositoryInterface $wordTranslationRepository
    )
    {
        $this->courseRepository = $courseRepository;
        $this->wordTranslationRepository = $wordTranslationRepository;
    }

    public function wordsByStatus($status, $page, $limit, $search) : array
    {
        $data = [];
        $user = AuthHelper::user();
        switch ($status) {
            case StatusWordDictionary::NONE:
                $courses = $this->courseRepository->getCoursesByStatus($user->id, [StatusWordDictionary::LEARNING, StatusWordDictionary::LEARNED]);
                $wordTranslations = $this->wordTranslationRepository->getSearchNewWords(
                    $user->base_language_id,
                    $user->target_language_id,
                    array_column($courses->toArray(), 'word_translation_id'),
                    $page,
                    $limit,
                    $search
                );
                foreach ($wordTranslations as $wordTranslation) {
                    $data[] = (new WordProgressDTO(
                        id: $wordTranslation->id,
                        text: $wordTranslation->word->text,
                        translation: $wordTranslation->translation,
                        transcription: $wordTranslation->word->transcription,
                        level: LevelDictionary::get($wordTranslation->word->level),
                        repeatTime: null
                    ))->toArray();
                }
                $amountWords = $this->wordTranslationRepository->countSearchNewWords(
                    $user->base_language_id,
                    $user->target_language_id,
                    array_column($courses->toArray(), 'word_translation_id'),
                    $search
                );
                break;
            case StatusWordDictionary::LEARNED:
            case StatusWordDictionary::LEARNING:
                $courses = $this->courseRepository->getByStatus($status, $user->id, $page, $limit, $search);
                foreach ($courses as $course) {
                    $data[] = (new WordProgressDTO(
                        id: $course->id,
                        text: $course->wordTranslation->word->text,
                        translation: $course->wordTranslation->translation,
                        transcription: $course->wordTranslation->word->transcription,
                        level: LevelDictionary::get($course->wordTranslation->word->level),
                        repeatTime: (new DateTime($course->last_time_repeated))->format('d.m.Y H:i:s')
                    ))->toArray();
                }
                $amountWords = $this->courseRepository->countByStatus($status, $user->id, $search);
                break;
            default:
                $amountWords = 0;
                break;
        }
        return [
            'data' => $data,
            'amountWords' => $amountWords,
        ];
    }
    public function clearProgress() : void
    {
        DB::beginTransaction();
        try{
            $user = AuthHelper::user();
            $this->courseRepository->deleteProgress($user->id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
    }

    public function clearWordProgress($id) : void
    {
        DB::beginTransaction();
        try{
            $this->courseRepository->deleteWordProgress($id);
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
    }

    public function newWord() : array|null
    {
        $user = AuthHelper::user();
        if (count($this->courseRepository->getRepeatWords($user->id)) > 0) {
            $course = $this->courseRepository->getOldLearningWords($user->id);
            $data = (new WordTrainingDTO(
                id: $course->word_translation_id,
                text: $course->wordTranslation->word->text,
                translation: $course->wordTranslation->translation,
                transcription: $course->wordTranslation->word->transcription,
                level: LevelDictionary::get($course->wordTranslation->word->level),
                status: $course->status,
                repeat: $course->repeat
            ))->toArray();
        }
        else {
            $courses = $this->courseRepository->getCoursesByStatus($user->id, [StatusWordDictionary::LEARNING, StatusWordDictionary::LEARNED]);
            $wordTranslation = $this->wordTranslationRepository->getNewWord($user->base_language_id, $user->target_language_id, array_column($courses->toArray(), 'word_translation_id'));
            $data = (new WordTrainingDTO(
                id: $wordTranslation->id,
                text: $wordTranslation->word->text,
                translation: $wordTranslation->translation,
                transcription: $wordTranslation->word->transcription,
                level: LevelDictionary::get($wordTranslation->word->level),
                status: StatusWordDictionary::NONE,
                repeat: 0
            ))->toArray();
        }
        return $data;
    }

    public function repeat($id, $status) : void
    {
        DB::beginTransaction();
        try {
            $user = AuthHelper::user();
            $course = $this->courseRepository->getCourseByWordTranslationIdAndUserId($id, $user->id);
            if ($course) {
                if($status) {
                    $this->courseRepository->update($course->id, [
                        'repeat' => $course->repeat + 1,
                        'status' => $course->repeat > Course::REPEAT_TIME ? StatusWordDictionary::LEARNED : StatusWordDictionary::LEARNING,
                        'last_time_repeated' => RepeatHelper::repeat($course->repeat)
                    ]);
                }
                else {
                    $this->courseRepository->update($course->id, [
                        'status' => StatusWordDictionary::LEARNING,
                        'last_time_repeated' => date("Y-m-d H:i:s", strtotime("+10 minutes"))
                    ]);
                }
            }
            else {
                if($status) {
                    $this->courseRepository->insert([
                        'word_translation_id' => $id,
                        'user_id' => $user->id,
                        'status' => StatusWordDictionary::LEARNED,
                        'repeat' => 0,
                        'last_time_repeated' => now()
                    ]);
                }
                else {
                    $this->courseRepository->insert([
                        'word_translation_id' => $id,
                        'user_id' => $user->id,
                        'status' => StatusWordDictionary::LEARNING,
                        'repeat' => 0,
                        'last_time_repeated' => RepeatHelper::repeat(0)
                    ]);
                }
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            LogHelper::errorLog($e->getTrace(), $e->getMessage());
        }
    }

    public function status() : array
    {
        $user = AuthHelper::user();
        $allWordsAmount = count($this->wordTranslationRepository->getByTargetLanguageIdAndBaseLanguageId($user->base_language_id, $user->target_language_id));
        $amountLearnedWords = count($this->courseRepository->getCoursesByStatus($user->id, [StatusWordDictionary::LEARNED]));
        $amountLearningWords = count($this->courseRepository->getRepeatWords($user->id));
        if($amountLearnedWords === $allWordsAmount) {
            return [
                'language' => $user->targetLanguage->code,
                'training' => StatusWordDictionary::LEARNED,
            ];
        }
        else {
            if ($amountLearningWords === 0 && $allWordsAmount === count($this->courseRepository->getCoursesByStatus($user->id, [StatusWordDictionary::LEARNED, StatusWordDictionary::LEARNING]))) {
                return [
                    'language' => $user->targetLanguage->code,
                    'training' => StatusWordDictionary::LEARNING,
                ];
            }
            else {
                //есть невыученные/ещё не повторенные слова (ещё даже не показанные)
                return [
                    'language' => $user->targetLanguage->code,
                    'training' => StatusWordDictionary::NONE,
                ];
            }
        }
    }
}
