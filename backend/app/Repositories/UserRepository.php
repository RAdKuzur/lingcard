<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserRepository implements UserRepositoryInterface
{
    public function all() {
        return User::all();
    }
    public function find($id) {
        return User::find($id);
    }
    public function getUserByCredentials($email, $password) {
        $user = User::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return null;
    }
    public function insert($data) : bool {
        return DB::table('users')->insert($data);
    }

    public function update($id , $data) : int {
        return DB::table('users')->where('id', $id)->update($data);
    }
    public function delete($id) : int {
        return DB::table('users')->where('id', $id)->delete();
    }
    public function unique($email, $name) : int {
        return !DB::table('users')->where('email', $email)->orWhere('name', $name)->exists();
    }
}
