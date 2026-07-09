<?php

namespace App\Dictionaries;

class LevelDictionary implements BaseDictionary
{
    public const BEGINNER = 1;
    public const ELEMENTARY = 2;
    public const INTERMEDIATE = 3;
    public const UPPER_INTERMEDIATE = 4;
    public const ADVANCED = 5;
    public const PROFICIENCY = 6;
    public static function getList(): array
    {
        return [
            self::BEGINNER => 'Начальный',
            self::ELEMENTARY => 'Базовый',
            self::INTERMEDIATE => 'Средний',
            self::UPPER_INTERMEDIATE => 'Выше среднего',
            self::ADVANCED => 'Продвинутый',
            self::PROFICIENCY => 'Профессиональный',
        ];
    }

    public static function get(int $index) {
        return self::getList()[$index];
    }
}
