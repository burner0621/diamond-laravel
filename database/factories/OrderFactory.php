<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
            'id_user' => User::factory(),
            'address1' => $this->faker->unique()->address(),
            'address2' => $this->faker->unique()->address(),
            'status' => Arr::random(Order::$status_list),
            'tracking_number' => $this->faker->unique()->randomNumber(6, true),
            'total_price' => $this->faker->numberBetween(100, 50000)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Order $order) {
            OrderItem::factory()->count(random_int(1, 5))
                ->state([
                    'id_order' => $order->id
                ])
                ->create();
        });
    }
}
