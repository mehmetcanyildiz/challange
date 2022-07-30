<?php

namespace Database\Factories;

use App\Models\App;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class AppFactory extends Factory
{
    /**
     * App Model
     * @var string
     */
    protected $model = App::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'callback' => fake()->url(),
        ];
    }
}
