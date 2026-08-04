<?php

namespace Tests\Feature;


use Database\Seeders\LanguageSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    public function test_bad_request_register(): void
    {
        $this->seed(LanguageSeeder::class);
        $this->seed(UserSeeder::class);
        $data = [];
        $response = $this->post('api/register', $data);
        $response->assertStatus(422);
    }
}
