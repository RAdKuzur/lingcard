<?php

namespace App\Dictionaries;

class StatusNewsDictionary implements BaseDictionary
{
    public const WAITING = 1;
    public const APPROVED = 2;
    public const REJECTED = 3;

    public static function getList(): array
    {
        return [
            self::WAITING => 'В ожидании рассмотрения',
            self::APPROVED => 'Одобрено к публикации',
            self::REJECTED => 'Отказано в публикации',
        ];
    }

    public static function get(int $index) {
        return self::getList()[$index];
    }
}
