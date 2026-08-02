<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

#[Signature('app:translate-command')]
#[Description('Command description')]
class TranslateCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = base_path('data/words/');
        $rawDatasets = ['fr'];
        $source = 'es';
        foreach ($rawDatasets as $rawDataset) {
            $file = fopen($path . "$source/en.jsonl", "r");
            $index = 0;
            $fopen = fopen($path . "$source/". $this->transform($rawDataset) . '.jsonl', "w");

            while (($line = fgets($file)) !== false) {
                $wordData = json_decode($line);
                $sourceLanguage = $source;
                $targetLanguage = $rawDataset;
                $level = $wordData->level;
                $word = $wordData->{$source};
                $url = "http://translate.googleapis.com/translate_a/single?client=gtx&sl=$sourceLanguage&tl=$targetLanguage&dt=t&q=" . urlencode($word);
                $translation = "TRANSLATION_FAILED";

                try {
                    $response = Http::retry(5, 1000)
                        ->timeout(15)
                        ->get($url);

                    if ($response->successful()) {
                        $jsonData = $response->json();
                        if ($jsonData && isset($jsonData[0][0][0])) {
                            $translation = $jsonData[0][0][0];
                        } else {
                            echo "Ошибка парсинга ответа для '$word'\n";
                        }
                    } else {
                        echo "HTTP Ошибка " . $response->status() . " для '$word'\n";
                    }

                } catch (ConnectionException $e) {
                    echo "Соединение разорвано для '$word' после всех попыток: " . $e->getMessage() . "\n";
                }

                fwrite($fopen, json_encode([
                        $source => $word,
                        $this->transform($rawDataset) => strtolower($translation),
                        'level' => $level,
                    ], JSON_UNESCAPED_UNICODE) . PHP_EOL);

                $index++;
                echo $index . '   ----   ' . $word . '  ---  '. $translation . PHP_EOL;
                usleep(200000);
            }
            fclose($file);
            fclose($fopen);
        }
    }

    public function transform($language)
    {
        switch ($language) {
            case 'zh':
                return 'cn';
            case 'ko':
                return 'kr';
            case 'ar':
                return 'sa';
            default:
                return $language;
        }
    }
}
