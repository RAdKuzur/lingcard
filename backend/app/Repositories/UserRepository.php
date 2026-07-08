<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserRepository
{
    public function getUserByCredentials($email, $password) {
        $user = User::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return null;
    }
    public function create($data) {
        return DB::table('users')->insert($data);
    }

    public function update($id , $data) {
        return DB::table('users')->where('id', $id)->update($data);
    }

    public function unique($email, $name) {
        return !DB::table('users')->where('email', $email)->orWhere('name', $name)->exists();
    }
}
