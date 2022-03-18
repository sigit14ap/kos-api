<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{
    User,
    Kost
};

class KostTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test search kost user.
     *
     * @return void
     */
    public function test_user_search_kost()
    {
        $user = User::factory()->create([
            'user_type' =>  'regular'
        ]);

        $response = $this->actingAs($user, 'api')->getJson('/api/v1/user/kost/search', [
            'page'          =>  1,
            'per_page'      =>  15,
            'search'        =>  'Kos',
            'min_price'     =>  10000,
            'min_price'     =>  1000000,
            'sort_price'    =>  'ASC'
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test detail kost user success.
     *
     * @return void
     */
    public function test_user_detail_kost_success()
    {
        $owner = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($owner->id)->create();

        $user = User::factory()->create([
            'user_type' =>  'regular'
        ]);

        $response = $this->actingAs($user, 'api')->getJson('/api/v1/user/kost/detail/'.$kost->id);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test detail kost user data not found.
     *
     * @return void
     */
    public function test_user_detail_kost_data_not_found()
    {
        $user = User::factory()->create([
            'user_type' =>  'regular'
        ]);

        $response = $this->actingAs($user, 'api')->getJson('/api/v1/user/kost/detail/99999999');

        $response->assertStatus(404);
    }

    /**
     * A basic feature test ask room availability kost user success.
     *
     * @return void
     */
    public function test_user_ask_room_availability_kost_success()
    {
        $owner = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($owner->id)->create();

        $user = User::factory()->create([
            'user_type' =>  'regular',
            'credit'    =>  20,
        ]);

        $response = $this->actingAs($user, 'api')->postJson('/api/v1/user/kost/ask-availability/'.$kost->id);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test ask room availability kost user not enough credit.
     *
     * @return void
     */
    public function test_user_ask_room_availability_kost_not_enough_credit()
    {
        $owner = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($owner->id)->create();

        $user = User::factory()->create([
            'user_type' =>  'regular',
            'credit'    =>  0,
        ]);

        $response = $this->actingAs($user, 'api')->postJson('/api/v1/user/kost/ask-availability/'.$kost->id);

        $response->assertStatus(400);
    }

    /**
     * A basic feature test ask room availability kost user data not found.
     *
     * @return void
     */
    public function test_user_ask_room_availability_kost_data_not_found()
    {
        $owner = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($owner->id)->create();

        $user = User::factory()->create([
            'user_type' =>  'regular',
            'credit'    =>  20,
        ]);

        $response = $this->actingAs($user, 'api')->postJson('/api/v1/user/kost/ask-availability/9999999');

        $response->assertStatus(404);
    }

    /**
     * A basic feature test ask room availability kost user access denied.
     *
     * @return void
     */
    public function test_user_ask_room_availability_kost_access_denied()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($user->id)->create();

        $response = $this->actingAs($user, 'api')->postJson('/api/v1/user/kost/ask-availability/9999999');

        $response->assertStatus(403);
    }
}
