<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:transform-wiki-data-command')]
#[Description('Command description')]
class TransformWikiDataCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseFilePath = base_path('data/jsonl');
        $files = array_diff(scandir($baseFilePath), ['.', '..', '.gitkeep']);
        foreach ($files as $file) {
            $fileName = str_replace('.jsonl', '', $file);
            $languages = explode('-', $fileName);

            if (!file_exists(base_path('data/' . $languages[0] .'-' . $languages[1] . '.jsonl'))) {
                $fileDescriptor = fopen($baseFilePath . '/' . $file, 'r');
                $fileWriteDescriptor = fopen(base_path('data/' . $languages[0] .'-' . $languages[1] . '.jsonl'), 'w');
                while (($line = fgets($fileDescriptor)) !== false) {
                    $word = json_decode($line);
                    foreach ($word->senses as $sense) {
                        if (isset($sense->glosses)) {
                            foreach ($sense->glosses as $gloss) {
                                echo $word->word . ' ' . $gloss . PHP_EOL;
                                $json = json_encode([
                                    $languages[0] => $word->word,
                                    $languages[1] => $gloss,
                                    "level" => 0
                                ], JSON_UNESCAPED_UNICODE);
                                fwrite($fileWriteDescriptor, $json . PHP_EOL);
                            }
                        }
                    }
                }
                fclose($fileDescriptor);
                fclose($fileWriteDescriptor);
            }
        }
    }
}
