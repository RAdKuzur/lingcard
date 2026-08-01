<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
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
        $rawDatasets = [
            'pt', 'ar', 'ko'
        ];

        foreach ($rawDatasets as $rawDataset) {
            $file = fopen($path . 'en/fr.jsonl', "r");
            $index = 0;
            $fopen = fopen($path . 'en/'. $this->transform($rawDataset) . '.jsonl', "w");
            while (($line = fgets($file)) !== false) {
                $word = json_decode($line);
                $sourceLanguage = 'en';
                $targetLanguage = $rawDataset;
                $level = $word->level;
                $word = $word->en;
                $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=$sourceLanguage&tl=$targetLanguage&dt=t&q=$word";
                $response = Http::get($url);
                $translation = $response->json()[0][0][0];
                $index++;
                fwrite($fopen, json_encode(
                    [
                        'en' => $word,
                        $this->transform($rawDataset) => strtolower($translation),
                        'level' => $level,
                    ], JSON_UNESCAPED_UNICODE
                ) . PHP_EOL);
                echo $index . '   ----   ' . $word . '  ---  '. $translation . PHP_EOL;
            }
            fclose($file);
            fclose($fopen);
        }
    }

    public function transform($language)
    {
        switch ($language) {
            case 'ko':
                return 'kr';
            case 'ar':
                return 'sa';
            default:
                return $language;
        }
    }
}
