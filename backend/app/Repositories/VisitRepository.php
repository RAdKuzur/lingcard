<?php

namespace App\Repositories;

use App\Models\Visit;
use App\Repositories\Interfaces\VisitRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VisitRepository implements VisitRepositoryInterface
{
    public function all() {
        return Visit::all();
    }
    public function find($id) {
        return Visit::find($id);
    }
    public function insert($data) : bool {
        return DB::table('visits')->insert($data);
    }
    public function update($id , $data) : int {
        return DB::table('visits')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('visits')->where('id', $id)->delete();
    }

}
