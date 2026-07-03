<?php

namespace App\Dictionaries;

class LevelDictionary implements BaseDictionary
{
    public const EASY = 1;
    public const MEDIUM = 2;
    public const HARD = 3;
    public static function getList(): array
    {
        return [
            self::EASY => 'Лёгкий',
            self::MEDIUM => 'Средний',
            self::HARD => 'Сложный',
        ];
    }

    public static function get(int $index) {
        return self::getList()[$index];
    }
}
