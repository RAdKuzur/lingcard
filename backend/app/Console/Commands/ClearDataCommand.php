<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('database:clear')]
#[Description('Clear custom database')]
class ClearDataCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('courses')->truncate();
        DB::table('posts')->truncate();

        DB::table('users')->truncate();

        DB::table('words')->truncate();
        DB::table('word_translations')->truncate();

        DB::table('authors')->truncate();
        DB::table('books')->truncate();
        DB::table('chapters')->truncate();

        DB::table('available_languages')->truncate();
        DB::table('languages')->truncate();

        DB::table('transfers')->truncate();
    }
}
