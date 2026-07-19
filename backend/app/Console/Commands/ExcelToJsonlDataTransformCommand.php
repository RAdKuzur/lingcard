<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

#[Signature('app:excel-to-jsonl-data-transform-command')]
#[Description('Command description')]
class ExcelToJsonlDataTransformCommand extends Command
{
    const PATH = 'data/excel/en.xlsx';
    const JSON_PATH = 'data/en-ru.jsonl';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $path = self::PATH;
        if (file_exists($path)) {
            $file = fopen(self::JSON_PATH, 'w+');
            $spreadsheet = IOFactory::load($path);

            $sheet = $spreadsheet->getActiveSheet();
            $words = $sheet->toArray();
            foreach ($words as $word) {
                $item = [
                    'en' => trim(str_replace('*', '', $word[0])),
                    'ru' => trim(str_replace('*', '', $word[2])),
                    'level' => (int)$word[3],
                ];
                $json = json_encode($item, JSON_UNESCAPED_UNICODE);

                fwrite($file, $json . "\n");
            }
            fclose($file);
        }
    }
}
