<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getUserByCredentials($name, $password);
    public function unique($name);
}
