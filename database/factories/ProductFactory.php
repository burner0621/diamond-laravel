<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'price' => $this->faker->numberBetween(100, 50000),
            'description' => $this->faker->paragraphs(3, true),
            'name' => ucfirst($this->faker->unique()->word()),
            'category' => Arr::random(Product::$category_list),
            'quantity' => $this->faker->numberBetween(1, 20)
        ];
    }

    public function withRandomId()
    {
        return $this->state([
            'id' => $this->faker->randomNumber(5, true)
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function(Product $product) {
            ProductImage::factory()->count(random_int(2, 7))
                ->create([
                    'id_product' => $product->id
                ]);
        });
    }
}
