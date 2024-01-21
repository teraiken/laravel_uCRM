<?php

namespace Database\Factories;

use App\Enums\PurchaseStatus;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $decade = $this->faker->dateTimeThisDecade();
        $created_at = $decade->modify('+2 years');

        return [
            'customer_id' => rand(1, Customer::count()),
            'status' => $this->faker->randomElement(PurchaseStatus::class),
            'created_at' => $created_at
        ];
    }
}
