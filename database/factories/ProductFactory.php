<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'sku' => $this->faker->ein(),
            'price' => $this->faker->numberBetween(10, 200),
            'description' => $this->faker->sentence(5),
            'active' => $this->faker->boolean(),
        ];
    }
}
