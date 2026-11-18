<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
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
        Artisan::call("migrate:reset --force");
        Artisan::call("migrate --force");
    }
}
