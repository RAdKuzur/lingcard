<?php

namespace Database\Seeders;

use App\Dictionaries\RoleDictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'name' => 'RKuzur',
            'base_language_id' => DB::table('languages')->where('code', 'ru')->first()->id,
            'target_language_id' => DB::table('languages')->where('code', 'kz')->first()->id,
            'role' => RoleDictionary::ADMIN,
        ]);
    }
}
