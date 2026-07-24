<?php

namespace App\Dictionaries;


class StatusReactionDictionary implements BaseDictionary
{
    public const LIKE = 1;
    public const DISLIKE = 2;
    public static function getList(): array
    {
        return [
            self::LIKE => 'Лайк',
            self::DISLIKE => 'Дизлайк',
        ];
    }

    public static function get(int $index) {
        return self::getList()[$index];
    }
}
