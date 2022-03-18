<?php

namespace Tests\Feature\Owner;

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
     * A basic feature test list kost owner.
     *
     * @return void
     */
    public function test_owner_list_kost()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $response = $this->actingAs($user, 'api')->getJson('/api/v1/owner/kost', [
            'page'      => 1,
            'per_page'  => 15,
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test create kost owner success.
     *
     * @return void
     */
    public function test_owner_create_kost_success()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $response = $this->actingAs($user, 'api')->postJson('/api/v1/owner/kost', [
            'user_id'   =>  $user->id,
            'name'      =>  $this->faker->word(),
            'location'  =>  $this->faker->address(),
            'price'     =>  $this->faker->randomNumber(6, true),
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test create kost owner failed validation.
     *
     * @return void
     */
    public function test_owner_create_kost_failed_validation()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $response = $this->actingAs($user, 'api')->postJson('/api/v1/owner/kost', [
            'name'      =>  $this->faker->word(),
            'location'  =>  $this->faker->address(),
        ]);

        $response->assertStatus(422);
    }

     /**
     * A basic feature test create kost owner access denied.
     *
     * @return void
     */
    public function test_owner_create_kost_access_denied()
    {
        $user = User::factory()->create([
            'user_type' =>  'regular'
        ]);

        $response = $this->actingAs($user, 'api')->postJson('/api/v1/owner/kost', [
            'user_id'   =>  $user->id,
            'name'      =>  $this->faker->word(),
            'location'  =>  $this->faker->address(),
            'price'     =>  $this->faker->randomNumber(6, true),
        ]);

        $response->assertStatus(403);
    }

    /**
     * A basic feature test create kost owner authentication failed.
     *
     * @return void
     */
    public function test_owner_create_kost_authentication_failed()
    {
        $response = $this->postJson('/api/v1/owner/kost', [
            'name'      =>  $this->faker->word(),
            'location'  =>  $this->faker->address(),
            'price'     =>  $this->faker->randomNumber(6, true),
        ]);

        $response->assertStatus(401);
    }

    /**
     * A basic feature test update kost owner success.
     *
     * @return void
     */
    public function test_owner_update_kost_success()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($user->id)->create();
        
        $response = $this->actingAs($user, 'api')->putJson('/api/v1/owner/kost/'.$kost->id, [
            'name'      =>  $this->faker->word(),
            'location'  =>  $this->faker->address(),
            'price'     =>  $this->faker->randomNumber(6, true),
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test update kost owner failed validation.
     *
     * @return void
     */
    public function test_owner_update_kost_failed_validation()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($user->id)->create();
        
        $response = $this->actingAs($user, 'api')->putJson('/api/v1/owner/kost/'.$kost->id, [
            'name'      =>  $this->faker->word(),
            'location'  =>  $this->faker->address(),
        ]);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test update kost owner data not found.
     *
     * @return void
     */
    public function test_owner_update_kost_not_found()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($user->id)->create();
        
        $response = $this->actingAs($user, 'api')->putJson('/api/v1/owner/kost/99999999', [
            'name'      =>  $this->faker->word(),
            'location'  =>  $this->faker->address(),
            'price'     =>  $this->faker->randomNumber(6, true),
        ]);

        $response->assertStatus(404);
    }

    /**
     * A basic feature test delete kost owner success.
     *
     * @return void
     */
    public function test_owner_delete_kost_success()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($user->id)->create();
        
        $response = $this->actingAs($user, 'api')->deleteJson('/api/v1/owner/kost/'.$kost->id);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test delete kost owner data not found.
     *
     * @return void
     */
    public function test_owner_delete_kost_not_found()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($user->id)->create();
        
        $response = $this->actingAs($user, 'api')->deleteJson('/api/v1/owner/kost/99999999');

        $response->assertStatus(404);
    }

    /**
     * A basic feature test detail kost owner success.
     *
     * @return void
     */
    public function test_owner_detail_kost_success()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($user->id)->create();
        
        $response = $this->actingAs($user, 'api')->getJson('/api/v1/owner/kost/'.$kost->id);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test detail kost owner data not found.
     *
     * @return void
     */
    public function test_owner_detail_kost_not_found()
    {
        $user = User::factory()->create([
            'user_type' =>  'owner'
        ]);

        $kost = Kost::factory()->userId($user->id)->create();
        
        $response = $this->actingAs($user, 'api')->getJson('/api/v1/owner/kost/99999999');

        $response->assertStatus(404);
    }
}
