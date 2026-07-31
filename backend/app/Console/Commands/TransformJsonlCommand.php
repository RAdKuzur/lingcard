<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:transform-jsonl-command')]
#[Description('Command description')]
class TransformJsonlCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseFilePath = base_path('data/words/kz/words_fr.jsonl');
        $createdFilePath = base_path('data/words/kz/fr.jsonl');
        $file = fopen($baseFilePath, 'r');
        $file2 = fopen($createdFilePath, 'w');
        while (($line = fgets($file)) !== false) {
            $word = json_decode($line);
            $data = [
                'kz' => strtolower($word->kz),
                'fr' => strtolower($word->fr),
                'level' => $word->level,
            ];
            fwrite($file2, json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL);
        }
    }
    public function level($index)
    {
        switch ($index) {
            case $index < 1000:
                return 1;
            case $index >= 1000 && $index < 2000:
                return 2;
            case $index >= 2000 && $index < 3000:
                return 3;
            case $index >= 3000 && $index < 4000:
                return 4;
            case $index >= 4000 && $index < 5000:
                return 5;
            case $index >= 5000:
                return 6;
        }
    }
}
