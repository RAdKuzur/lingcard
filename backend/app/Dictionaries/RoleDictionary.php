<?php

namespace App\Dictionaries;

class RoleDictionary implements BaseDictionary
{
    public const USER = 1;
    public const ADMIN = 2;

    public static function getList(): array
    {
        return [
            self::USER => 'Пользователь',
            self::ADMIN => 'Администратор',
        ];
    }

    public static function get(int $index) {
        return self::getList()[$index];
    }
}
