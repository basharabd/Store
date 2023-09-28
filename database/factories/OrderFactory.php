<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'store_id' => \App\Models\Store::factory(), // You should adjust this to match your Store model
            'user_id' => \App\Models\User::factory()->nullable(), // You should adjust this to match your User model
            'number' => $this->faker->unique()->randomNumber(),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'cash']),
            'status' => $this->faker->randomElement(['pending', 'processing', 'delivering', 'completed', 'cancelled', 'refunded']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'shipping' => $this->faker->randomFloat(2, 0, 100),
            'tax' => $this->faker->randomFloat(2, 0, 20),
            'discount' => $this->faker->randomFloat(2, 0, 50),
            'total' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
