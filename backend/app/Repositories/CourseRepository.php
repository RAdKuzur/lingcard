<?php

namespace App\Repositories;

use App\Dictionaries\StatusDictionary;
use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CourseRepository implements CourseRepositoryInterface
{
    public function all() {
        return Course::all();
    }
    public function find($id) {
        return Course::where('id', $id)->first();
    }
    public function getUserCourses($userId) {
        return Course::where(['user_id' => $userId])->get();
    }

    public function getOldLearningWords($userId)
    {
        return Course::with('wordTranslation.word')
            ->join('word_translations', 'courses.word_translation_id', '=', 'word_translations.id')
            ->join('words', 'word_translations.word_id', '=', 'words.id')
            ->where('courses.user_id', $userId)
            ->where('courses.last_time_repeated', '<', now())
            ->whereIn('courses.status', [StatusDictionary::NONE, StatusDictionary::LEARNING])
            ->orderBy('courses.status', 'desc')
            ->orderBy('courses.last_time_repeated', 'desc')
            ->select('courses.*')
            ->first();
    }

    public function updateUserCourses($userId, $data) {
        return Course::where(['user_id' => $userId])->update($data);
    }

    public function getByStatus($status, $userId ,$page = 1, $limit = 10, $search = '') {
        return Course::with('wordTranslation.word')
            ->join('word_translations', 'courses.word_translation_id', '=', 'word_translations.id')
            ->join('words', 'word_translations.word_id', '=', 'words.id')
            ->where('user_id', $userId)
            ->where('status', $status)
            ->where('words.text', 'LIKE', '%' . $search . '%')
            ->select('courses.*', 'courses.id as id')
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function countByStatus($status, $search = '') {
        return Course::with('wordTranslation')->with('wordTranslation.word')
            ->join('word_translations', 'courses.word_translation_id', '=', 'word_translations.id')
            ->join('words', 'word_translations.word_id', '=', 'words.id')
            ->where('words.text', 'LIKE', '%' . $search . '%')
            ->where(['status' => $status])->count();
    }


    public function countUserStats($userId, $status) {
        return Course::where(['user_id' => $userId, 'status' => $status])->count();
    }

    public function deleteProgress($userId) {
        return DB::table('courses')->where(['user_id' => $userId])->delete();
    }

    public function deleteWordProgress($courseId) {
        return DB::table('courses')->where(['id' => $courseId])->update([
            'status' => StatusDictionary::NONE,
            'repeat' => 0,
            'last_time_repeated' => now()
        ]);
    }

    public function insert($data) : bool
    {
        return DB::table('courses')->insert($data);
    }

    public function update($id, $data) : int
    {
        return DB::table('courses')->where('id', $id)->update($data);
    }
    public function delete($id) : int
    {
        return DB::table('courses')->where('id', $id)->delete();
    }
}
