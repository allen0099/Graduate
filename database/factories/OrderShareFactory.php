<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderShare;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderShareFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderShare::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Order::find(7)->shared_users->map->only('id')->flatten()->all()
        // OrderShare::all()->where('order_id', 3)->map(fn($a) => $a->user_id);
        $order = $this->faker->randomElement(Order::all());
        $order_id = $order->id;
        $users = User::all()
            ->where('role', User::STUDENT)
            ->whereNotIn('id', $order->owner_id)
            ->whereNotIn('id', $order->shared_users->map->only('id')->flatten()->all());

        $user_id = $this->faker->randomElement($users)->id;

        return [
            'order_id' => $order_id,
            'user_id' => $user_id,
        ];
    }
}
