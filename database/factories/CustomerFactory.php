<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $company = $this->faker->company;

        return [
            'company_name' => $this->faker->company,
            'pib' => $this->faker->numerify('#########'),
            'mb' => $this->faker->numerify('########'),
            'email' => sprintf(
                'simo+%s@jakovic.com',
                strtolower(str_replace([' ', ','], ['-', ''], $company))
            ),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
        ];
    }
}
