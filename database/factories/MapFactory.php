<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Map>
 */
class MapFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'latitude' => fake()->latitude(min: -2.465326265760092, max: -3.408898622513109),
            'longitude' => fake()->longitude(min: 107.47843634964937, max: 107.8955540177306),
            'category_id' => Category::factory()
        ];
    }
}
