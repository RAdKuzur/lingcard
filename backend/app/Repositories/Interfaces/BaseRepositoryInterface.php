<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function all();
    public function find($id);
    public function insert(array $data) : bool;
    public function update($id, array $data) : int;
    public function delete($id) : int;
}
