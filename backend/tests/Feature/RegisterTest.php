<?php

namespace Tests\Feature;

use App\Dictionaries\RoleDictionary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_bad_request_register(): void
    {
        $data = [];
        $response = $this->post('api/register', $data);
        $response->assertStatus(422);
    }
}
