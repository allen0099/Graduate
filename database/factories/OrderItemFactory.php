<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantity = $this->faker->numberBetween(1, 10);

        do {
            $item = $this->faker->randomElement(Item::all());
        } while ($item->remain_quantity - $quantity < 0);

        return [
            'order_id' => Order::factory(),
            'item_id' => $item->id,
            'quantity' => $quantity
        ];
    }

    public function appendData()
    {
        $order = $this->faker->randomElement(Order::all());
        $quantity = $this->faker->numberBetween(1, 10);

        do {
            $item = $this->faker->randomElement(Item::all()->diff($order->items));
        } while ($item->remain_quantity - $quantity < 0);

        return $this->state(fn(array $attributes) => [
            'order_id' => $order->id,
            'item_id' => $item->id,
            'quantity' => $quantity
        ]);
    }
}
