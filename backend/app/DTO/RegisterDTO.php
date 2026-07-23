<?php

namespace App\DTO;

use App\Dictionaries\RoleDictionary;
use Illuminate\Support\Facades\DB;

class RegisterDTO implements BaseDTO
{
    public ?string $email;
    public ?string $name;
    public ?string $password;
    public ?int $baseLangId;
    public ?int $targetLangId;

    public function __construct(
        ?string $email = null,
        ?string $name = null,
        ?string $password = null,
        ?int $baseLangId = null,
        ?int $targetLangId = null
    ) {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->baseLangId = $baseLangId;
        $this->targetLangId = $targetLangId;
    }

    public function toArray(): array {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'password' => $this->password,
            'role' => RoleDictionary::USER,
            'target_language_id' => $this->targetLangId,
            'base_language_id' => $this->baseLangId,
            'is_banned' => false
        ];
    }

}
