<?php

namespace App\Repositories\Interfaces;

interface CourseRepositoryInterface extends BaseRepositoryInterface
{
    public function getUserCourses($userId);
    public function getOldLearningWords($userId);
    public function updateUserCourses($userId, $data);
    public function getByStatus($status, $userId ,$page, $limit, $search);
    public function countByStatus($status, $search);
    public function countUserStats($userId, $status);
    public function deleteProgress($userId);
    public function deleteWordProgress($courseId);
}
