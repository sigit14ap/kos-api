<?php

namespace Tests\Feature\Owner;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class DashboardTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test dashboard owner success.
     *
     * @return void
     */
    public function test_owner_dashboard_summary_success()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $response = $this->actingAs($user, 'api')->getJson('/api/v1/owner/dashboard/summary');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test dashboard owner access denied.
     *
     * @return void
     */
    public function test_owner_dashboard_summary_access_denied()
    {
        $user = User::factory()->create([
            'user_type' =>  'regular'
        ]);

        $response = $this->actingAs($user, 'api')->getJson('/api/v1/owner/dashboard/summary');

        $response->assertStatus(403);
    }
}
