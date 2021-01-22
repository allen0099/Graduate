<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document_id' => now()->format('Ymdhis') . str_pad($this->faker->unique()->numberBetween($min = 0, $max = 99999), 5, '0', STR_PAD_LEFT),
            'owner_id' => $this->faker->randomElement(User::all()->where('role', User::STUDENT))->id,
            'total_price' => 0,
            'status_code' => Order::code_created,
        ];
    }
}
