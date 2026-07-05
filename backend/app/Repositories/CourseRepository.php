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

    public function getByStatus($status, $page = 1, $limit = 10) {
        return Course::with('wordTranslation.word')
            ->where('status', $status)
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function countByStatus($status) {
        return Course::with('wordTranslation')->with('wordTranslation.word')->where(['status' => $status])->count();
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
