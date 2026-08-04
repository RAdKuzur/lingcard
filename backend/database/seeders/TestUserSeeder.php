<?php

namespace Database\Seeders;

use App\Dictionaries\RoleDictionary;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $language1 = Language::where('code', 'en')->first();
        $language2 = Language::where('code', 'ru')->first();
        $user = User::create([
            'email' => 'drive16052003@gmail.com',
            'password' => Hash::make('password'),
            'name' => 'LingCard',
            'base_language_id' => $language1->id,
            'target_language_id' => $language2->id,
            'role' => RoleDictionary::ADMIN,
            'is_banned' => false
        ]);
    }
}
