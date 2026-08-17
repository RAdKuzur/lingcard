<?php

namespace App\DTO;

class LoginDTO implements BaseDTO
{
    public string $name;
    public string $password;
    public function __construct(
        string $name,
        string $password
    )
    {
        $this->name = $name;
        $this->password = $password;
    }
    public function toArray() : array {
        return [
            'name' => $this->name,
            'password' => $this->password
        ];
    }
}
