<?php

namespace App\Repositories\Interfaces;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    public function all();
    public function allWithRelations();
    public function find($id);
}
