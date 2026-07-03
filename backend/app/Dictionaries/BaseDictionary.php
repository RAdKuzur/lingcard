<?php

namespace App\Dictionaries;

interface BaseDictionary
{
    public static function getList(): array;

    public static function get(int $index);
}
