<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

#[Signature('app:transform-excel-command')]
#[Description('Command description')]
class TransformExcelCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filepath = base_path() . "/data/excel/words.xlsx";

        $spreadsheet = IOFactory::load($filepath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $filePath = base_path() . "/data/words/base/ru.jsonl";
        $file = fopen($filePath, "w");
        foreach ($rows as $row) {
            $data = json_encode([
                'ru' => $row[0],
            ], JSON_UNESCAPED_UNICODE);
            fwrite($file, $data . PHP_EOL);
            echo $row[0]. "\n";
        }
        fclose($file);
    }
}
