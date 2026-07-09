<?php

namespace App\Repositories;

use App\Dictionaries\StatusDictionary;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseRepository
{
    public function getAll() {
        return Course::all();
    }
    public function getById($id) {
        return Course::where('id', $id)->first();
    }
    public function getUserCourses($userId) {
        return Course::where(['user_id' => $userId])->get();
    }

    public function getOldLearningWords($userId)
    {
        return Course::where(['user_id' => $userId])
            ->whereIn('status', [StatusDictionary::NONE, StatusDictionary::LEARNING])
            ->inRandomOrder()
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

    public function insert($data)
    {
        return DB::table('courses')->insert($data);
    }

    public function update($id, $data)
    {
        return DB::table('courses')->where('id', $id)->update($data);
    }
}
