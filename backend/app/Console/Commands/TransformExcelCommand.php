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
        $index = 0;
        $filepath = base_path() . "/data/excel/fr.xlsx";
        $spreadsheet = IOFactory::load($filepath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $filePath = base_path() . "/data/words/base/fr.jsonl";
        $file = fopen($filePath, "w");
        foreach ($rows as $row) {
            if ($row[0] && $index < 5000) {
                $data = json_encode([
                    'fr' => $row[0],
                ], JSON_UNESCAPED_UNICODE);
                fwrite($file, $data . PHP_EOL);
                $index = $index + 1;
            }
        }
        fclose($file);
    }
}
