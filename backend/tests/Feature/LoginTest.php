<?php

namespace Tests\Feature;

use App\Dictionaries\RoleDictionary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_successful_login(): void
    {
        $data = [
            'email' => 'drive16052003@gmail.com',
            'password' => 'password'
        ];
        $response = $this->post('/api/login', $data);
        $response->assertStatus(200);
    }
    public function test_bad_request_login(): void
    {
        $data = [

        ];
        $response = $this->post('/api/login', $data);
        $response->assertStatus(422);
    }

    public function test_wrong_credentials_login(): void
    {
        $data = [
            'email' => 'bad@email.com',
            'password' => 'bad_password',
        ];
        $response = $this->post('/api/login', $data);
        $response->assertStatus(401);
    }
}
