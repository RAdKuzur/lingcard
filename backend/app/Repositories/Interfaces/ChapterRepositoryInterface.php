<?php

namespace App\Repositories\Interfaces;

interface ChapterRepositoryInterface extends BaseRepositoryInterface
{
    public function all();
    public function find($id);
    public function findByBookID($bookID);
}
