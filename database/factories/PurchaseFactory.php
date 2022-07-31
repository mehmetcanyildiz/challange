<?php

namespace Database\Factories;

use App\Enum\PurchaseStatusEnum;
use App\Models\Device;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PurchaseFactory extends Factory
{
    /**
     * Purchase Model
     * @var string
     */
    protected $model = Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_id' => fake()->randomElement(Device::pluck('id')),
            'receipt' => Purchase::receipt(),
            'expire_time' => fake()->dateTimeBetween('now', '+10 month'),
            'status' => fake()->randomElement([
                PurchaseStatusEnum::PURCHASE_STATUS_PASSIVE,
                PurchaseStatusEnum::PURCHASE_STATUS_ACTIVE
            ])
        ];
    }
}
