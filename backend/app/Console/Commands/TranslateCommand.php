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
        $sourceLanguage = 'en';
        $targetLanguage = 'zh';
        $word = 'car';
        $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=$sourceLanguage&tl=$targetLanguage&dt=t&q=$word";
        $response = Http::get($url);

        $translation = $response->json()[0][0][0];
        echo $response;
    }
}
