<?php

namespace App\Repositories\Interfaces;

interface LanguageRepositoryInterface extends BaseRepositoryInterface
{
    public function allActive();
    public function findByCode($code);
}
