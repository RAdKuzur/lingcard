<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('votes')->truncate();
        DB::table('vote_options')->truncate();
        DB::table('voices')->truncate();

        $voteId = DB::table('votes')->insertGetId([
            'title' => 'Select a new language to add!',
            'content' => 'This is the first vote on LingCard! Your opinion is extremely important to us, because it is you who shape the future of our project. We invite you to choose the next language to be added for learning.',
            'is_active' => true
        ]);

        $languages = DB::table('languages')->where(['is_active' => false])->get();
        foreach ($languages as $language) {
            $content = json_encode([
                'picture' => "/flags/$language->code.svg",
                'code' => $language->code
            ]);
            DB::table('vote_options')->insert([
                'vote_id' => $voteId,
                'title' => $language->name,
                'content' => $content
            ]);
        }
    }
}
