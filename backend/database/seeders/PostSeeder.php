<?php

namespace Database\Seeders;

use App\Dictionaries\StatusPostDictionary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = DB::table('users')->where(['name' => 'LingCard'])->first()->id;
        $ruLangId = DB::table('languages')->where(['code' => 'ru'])->first()->id;
        $enLangId = DB::table('languages')->where(['code' => 'en'])->first()->id;
        $kzLangId = DB::table('languages')->where(['code' => 'kz'])->first()->id;
        $posts = [
            [
                'content' => 'Всем привет! Рады сообщить, что LingCard открыт для всех желающих изучать языки разных стран. Если интересующего вас языка нет, сообщите нам или проголосуйте за его добавление.',
                'date' => now(),
                'title' => 'Стартуем!',
                'language_id' => $ruLangId,
                'user_id' => $userId,
                'address' => 'Россия',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => 'Барлығына сәлем! LingCard түрлі елдердің тілдерін үйренгісі келетіндердің бәріне ашық екенін хабарлауға қуаныштымыз. Егер сізді қызықтыратын тіл жоқ болса, бізге хабарлаңыз немесе оны қосуды дауыстап қолдаңыз.',
                'date' => now(),
                'title' => 'Бастаймыз!',
                'language_id' => $kzLangId,
                'user_id' => $userId,
                'address' => 'Қазақстан',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ],
            [
                'content' => 'Hello everyone! We are happy to announce that LingCard is now open to everyone who wants to learn languages from different countries. If your language of interest is not available, let us know or vote for its addition.',
                'date' => now(),
                'title' => 'We\'re starting!',
                'language_id' => $enLangId,
                'user_id' => $userId,
                'address' => 'United Kingdom',
                'status' => StatusPostDictionary::APPROVED,
                'views_count' => 0,
                'likes_count' => 0,
                'dislikes_count' => 0
            ]
        ];

        DB::table('posts')->truncate();
        foreach ($posts as $post) {
            DB::table('posts')->insert($post);
        }
    }
}
