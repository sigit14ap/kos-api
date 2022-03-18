<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use WithFaker;

    public $data;

    /**
     * A basic feature test login success.
     *
     * @return void
     */
    public function test_login_success()
    {
        $password = 'Test123@';

        $user = User::factory()->create([
            'password'  =>  bcrypt($password)
        ]);
        
        $response = $this->postJson('/api/v1/auth/login', [
            'email'     => $user->email,
            'password'  => $password,
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test login failed validation.
     *
     * @return void
     */
    public function test_login_failed_validation()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email'     =>  'test@gmail.com',
        ]);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test login account not found.
     *
     * @return void
     */
    public function test_login_account_not_found()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email'     =>  'test@gmail.com',
            'password'  =>  'Testfailed',
        ]);

        $response->assertStatus(401);
    }
}
