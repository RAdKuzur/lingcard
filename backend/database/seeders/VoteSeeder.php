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
            'is_active' => true
        ]);


        $languages = DB::table('languages')->where(['is_active' => false])->get();
        foreach ($languages as $language) {
            DB::table('vote_options')->insert([
                'vote_id' => $voteId,
                'title' => $language->name,
                'content' => $language->code
            ]);
        }
    }
}
