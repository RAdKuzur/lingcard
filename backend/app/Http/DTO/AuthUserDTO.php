<?php

namespace App\Http\DTO;

class AuthUserDTO implements BaseDTO
{
    public ?string $role;
    public ?string $username;
    public function __construct(
        ?string $role = null,
        ?string $username = null
    )
    {
        $this->role = $role;
        $this->username = $username;
    }
    public function toArray() {
        return [
            'role' => $this->role,
            'username' => $this->username
        ];
    }
}
