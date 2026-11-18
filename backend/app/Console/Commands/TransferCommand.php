<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use RuntimeException;

#[Signature('transfer')]
#[Description('Transfer datasets')]
class TransferCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $transferPath = base_path('database/transfers');
        $arr = array_diff(scandir($transferPath), ['.', '..', 'base']);
        $arr = array_values($arr);

        foreach ($arr as $file) {
            $filePath = $transferPath . '/' . $file;
            if (!is_file($filePath)) {
                throw new RuntimeException("Файл не найден: $filePath");
            }
            $migration = require $filePath;
            if (!is_object($migration)) {
                throw new RuntimeException("Файл $file не вернул объект");
            }
            if (!method_exists($migration, 'up')) {
                throw new RuntimeException("В $file нет метода up()");
            }
            $name = defined(get_class($migration) . '::NAME')
                ? $migration::NAME
                : $file;

            $isExist = DB::table('transfers')->where(['name' => $name])->exists();
            if (!$isExist) {
                echo "Applying: $name\n";
                try {
                    $migration->up();
                    DB::table('transfers')->insert([
                        'name' => $name,
                        'time' => now(),
                    ]);
                    echo "Transfer $name applied.\n";
                }
                catch (RuntimeException $e) {
                    echo "Applying: $name failed.\n";
                }
            }
        }
    }
}
