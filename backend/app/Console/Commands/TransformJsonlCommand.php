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
        $language = 'sa';
        $words = [];
        $baseFilePath = base_path("data/words/jp/$language.jsonl");
        $createdFilePath = base_path("data/words/$language.jsonl");
        $file = fopen($baseFilePath, "r");
        $file2 = fopen($createdFilePath, 'w');
        $file3 = fopen(base_path("data/words/jp/en.jsonl"), 'r');
        while (($line = fgets($file)) !== false) {
            $word = json_decode($line);
            $line2 = fgets($file3);
            $word2 = json_decode($line2);
            fwrite($file2, json_encode([
                'jp' => $word->{'jp'},
                $language => $word->{$language},
                'transcription' => $word2->{'transcription'},
                'level' => $word->{'level'},
            ], JSON_UNESCAPED_UNICODE) . PHP_EOL);
        }
        fclose($file2);
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
    public function levelCEFR($level)
    {
        switch ($level) {
            case 'A1':
                return 1;
            case 'A2':
                return 2;
            case 'B1':
                return 3;
            case 'B2':
                return 4;
            case 'C1':
                return 5;
            case 'C2':
                return 6;
            default:
                return 6;
        }
    }

    function getWordField($entry) {
        // Проверяем наличие разных полей
        if (isset($entry['root_word'])) {
            return $entry['root_word'];
        } else
        if (isset($entry['word'])) {
            return strtolower($entry['word']);
        } else {
            throw new \Exception('Word not found');
        }
    }
}
