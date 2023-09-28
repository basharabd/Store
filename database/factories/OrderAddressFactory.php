<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderAddress>
 */
class OrderAddressFactory extends Factory
{
    protected $model = OrderAddress::class;

    public function definition()
    {
        $faker = \Faker\Factory::create();

        return [
            'order_id' => function () {
                return \App\Models\Order::factory()->create()->id;
            },
            'type' => $faker->randomElement(['billing', 'shipping']),
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'phone_number' => $faker->phoneNumber,
            'street_address' => $faker->streetAddress,
            'city' => $faker->city,
            'postal_code' => $faker->postcode,
            'state' => $faker->state,
            'country' => $faker->countryCode,
        ];
    }

}
