<?php

namespace Database\Factories;

use App\Models\App;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class DeviceFactory extends Factory
{
    /**
     * Device Model
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'app_id' => fake()->randomElement(App::pluck('id')),
            'uid' => Device::uid(),
            'language' => fake()->languageCode(),
            'os' => fake()->randomElement(['ios', 'android']),
            'token' => Device::hash(),
        ];
    }
}
