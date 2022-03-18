<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kost>
 */
class KostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'      =>  $this->faker->word(),
            'location'  =>  $this->faker->address(),
            'price'     =>  $this->faker->randomNumber(6, true),
        ];
    }

    public function userId($id)
    {
        return $this->state([
            'user_id' => $id
        ]);
    }
}
