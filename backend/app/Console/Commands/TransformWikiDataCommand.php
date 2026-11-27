<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use RuntimeException;

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

                $firstPath = base_path('data/filtered/' . $languages[0]);
                $secondPath = base_path('data/filtered/' . $languages[1]);
                if (!is_dir($firstPath)) {
                    if (!mkdir($firstPath, 0775, true) && !is_dir($firstPath)) {
                        throw new RuntimeException(sprintf('Не удалось создать директорию: %s', $firstPath));
                    }
                }
                if (!is_dir($secondPath)) {
                    if (!mkdir($secondPath, 0775, true) && !is_dir($secondPath)) {
                        throw new RuntimeException(sprintf('Не удалось создать директорию: %s', $secondPath));
                    }
                }

                $fileDescriptor = fopen($baseFilePath . '/' . $file, 'r');
                $fileWriteBaseDescriptor = fopen(base_path('data/words/base/' . $languages[0] . '.jsonl'), 'w'); // base words
                $fileWriteFirstDescriptor = fopen($firstPath . "/" . $languages[1] . ".jsonl", 'w');
                $fileWriteSecondDescriptor = fopen($secondPath . "/" . $languages[0] . ".jsonl", 'w');
                while (($line = fgets($fileDescriptor)) !== false) {
                    $word = json_decode($line);
                    foreach ($word->senses as $sense) {
                        if (isset($sense->glosses)) {
                            foreach ($sense->glosses as $gloss) {
                                if (($word->pos === 'noun' || $word->pos === 'verb' || $word->pos === 'adj' || $word->pos === 'adv' || $word->pos === 'num' || $word->pos === 'pron') &&
                                mb_strlen($word->word) < 200 && mb_strlen($gloss) < 200) {
                                    $json = json_encode([
                                        $languages[0] => $word->word,
                                    ], JSON_UNESCAPED_UNICODE);
                                    fwrite($fileWriteBaseDescriptor, $json . PHP_EOL);

                                    $json = json_encode([
                                        $languages[0] => $word->word,
                                        $languages[1] => $gloss,
                                        "transcription" => null,
                                        "level" => 1
                                    ], JSON_UNESCAPED_UNICODE);
                                    fwrite($fileWriteFirstDescriptor, $json . PHP_EOL);

                                    $json = json_encode([
                                        $languages[1] => $gloss,
                                        $languages[0] => $word->word,
                                        "transcription" => null,
                                        "level" => 1
                                    ], JSON_UNESCAPED_UNICODE);
                                    fwrite($fileWriteSecondDescriptor, $json . PHP_EOL);
                                }
                            }
                        }
                    }
                }
                fclose($fileDescriptor);
                fclose($fileWriteBaseDescriptor);
                fclose($fileWriteFirstDescriptor);
                fclose($fileWriteSecondDescriptor);
            }
        }
    }
}
