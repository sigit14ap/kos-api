<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test register success.
     *
     * @return void
     */
    public function test_register_success()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name'                  =>  $this->faker->firstName().' '.$this->faker->lastName(),
            'email'                 =>  $this->faker->unique()->safeEmail(),
            'password'              =>  'Test123@',
            'password_confirmation' =>  'Test123@',
            'user_type'             =>  'owner'
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test register failed validation.
     *
     * @return void
     */
    public function test_register_failed_validation()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name'                  =>  $this->faker->firstName().' '.$this->faker->lastName(),
            'email'                 =>  $this->faker->unique()->safeEmail(),
            'password'              =>  'Test123@',
            'password_confirmation' =>  'Tes123@',
            'user_type'             =>  'owner'
        ]);

        $response->assertStatus(422);
    }
}
