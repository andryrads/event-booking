<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['VIP','Standard']),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'quantity' => $this->faker->numberBetween(50, 200),
            'event_id' => Event::factory(),
        ];
    }
}
