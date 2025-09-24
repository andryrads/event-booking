<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'booking_id' => Booking::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 500),
            'status' => $this->faker->randomElement(['success','failed','refunded']),
        ];
    }
}
