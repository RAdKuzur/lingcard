<?php

namespace App\Dictionaries;

class StatusWordDictionary implements BaseDictionary
{
    public const NONE = 1;
    public const LEARNING = 2;
    public const LEARNED = 3;
    public static function getList(): array
    {
        return [
            self::NONE => 'Не выучено',
            self::LEARNING => 'В процессе обучения',
            self::LEARNED => 'Изучено'
        ];
    }

    public static function get(int $index) {
        return self::getList()[$index];
    }
}
