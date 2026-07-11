<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getUserByCredentials($email, $password);
    public function unique($email, $name);
}
