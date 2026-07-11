<?php

namespace App\Repositories\Interfaces;

interface TokenRepositoryInterface extends BaseRepositoryInterface
{
    public function getByRefreshToken($refreshToken);
    public function createToken($token, $userId);
    public function isValidJwtToken($token);
}
