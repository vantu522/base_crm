<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\Product\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'sku' => strtoupper($this->faker->unique()->bothify('SKU-#####')),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(12),
            'quantity' => $this->faker->numberBetween(0, 200),
            'price' => $this->faker->randomFloat(4, 10, 5000),
        ];
    }
}
