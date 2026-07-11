<?php

namespace App\Services;

use App\Dictionaries\LevelDictionary;
use App\Dictionaries\StatusDictionary;
use App\DTO\WordProgressDTO;
use App\DTO\WordTrainingDTO;
use App\Helpers\AuthHelper;
use App\Helpers\LogHelper;
use App\Jobs\InitProgressJob;
use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use DateTime;
use Illuminate\Support\Facades\DB;

class CourseService
{
    private CourseRepositoryInterface $courseRepository;
    public function __construct(
        CourseRepositoryInterface $courseRepository,
    )
    {
        $this->courseRepository = $courseRepository;
    }

    public function wordsByStatus($status, $page, $limit, $search) : array
    {
        $data = [];
        $user = AuthHelper::user();
        $courses = $this->courseRepository->getByStatus($status, $user->id, $page, $limit, $search);
        foreach ($courses as $course) {
            $data[] = (new WordProgressDTO(
                id: $course->id,
                text: $course->wordTranslation->word->text,
                translation: $course->wordTranslation->translation,
                level: LevelDictionary::get($course->wordTranslation->word->level),
                repeatTime: (new DateTime($course->last_time_repeated))->format('d.m.Y H:i:s')
            ))->toArray();
        }
        return [
            'data' => $data,
            'amountWords' => $this->courseRepository->countByStatus($status, $search),
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

    public function init() : bool
    {
        $user = AuthHelper::user();
        if($user && count($this->courseRepository->getUserCourses($user->id)) === 0) {
            InitProgressJob::dispatch($user->base_language_id, $user->target_language_id, $user->id);
            return true;
        }
        return false;
    }

    public function newWord() : array|null
    {

        $user = AuthHelper::user();
        $course = $this->courseRepository->getOldLearningWords($user->id);
        if($course) {
            $data = (new WordTrainingDTO(
                id: $course->id,
                text: $course->wordTranslation->word->text,
                translation: $course->wordTranslation->translation,
                level: LevelDictionary::get($course->wordTranslation->word->level),
                status: $course->status,
                repeat: $course->repeat
            ))->toArray();
            return $data;
        }
        return null;
    }

    public function repeat($id, $status) : void
    {
        DB::beginTransaction();
        try {
            $course = $this->courseRepository->find($id);
            if ($course && $status) {
                switch ($course->status) {
                    case StatusDictionary::NONE:
                        $this->courseRepository->update($id, [
                            'repeat' => $course->repeat + 1,
                            'status' => StatusDictionary::LEARNED,
                            'last_time_repeated' => now()
                        ]);
                        break;
                    case StatusDictionary::LEARNING:
                        $this->courseRepository->update($id, [
                            'repeat' => $course->repeat + 1,
                            'status' => $course->repeat + 1 > Course::REPEAT_TIME ? StatusDictionary::LEARNED : StatusDictionary::LEARNING,
                            'last_time_repeated' => date("Y-m-d H:i:s", strtotime("+1 days"))
                        ]);
                        break;
                    default:
                        break;
                }
            }
            else {
                switch ($course->status) {
                    case StatusDictionary::NONE:
                        $this->courseRepository->update($id, [
                            'status' => StatusDictionary::LEARNING,
                            'last_time_repeated' => date("Y-m-d H:i:s", strtotime("+10 minutes"))
                        ]);
                        break;
                    default:
                        break;
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
        if(count($this->courseRepository->getUserCourses($user->id)) > 0) {
            return [
                'language' => $user->targetLanguage->code,
                'training' => true
            ];
        }

        return [
            'language' => $user->targetLanguage->code,
            'training' => false
        ];
    }
}
