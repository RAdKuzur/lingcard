<?php

namespace App\Repositories\Interfaces;

interface AvailableLanguageRepositoryInterface extends BaseRepositoryInterface
{
    public function findByBaseLanguageId($baseLanguageId);
}
