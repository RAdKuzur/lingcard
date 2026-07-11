<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news')->truncate();
        DB::table('news')->insert([
            'content' => 'Text 1',
            'date' => now(),
            'title' => 'Title 1',
        ]);
        DB::table('news')->insert([
            'content' => 'Text 2',
            'date' => now()->addDay(),
            'title' => 'Title 2',
        ]);
    }
}
