<?php

namespace Database\Factories;

use App\Models\Accessory;
use App\Models\Cloth;
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
            'document_id' => $this->faker->uuid,
            'owner_id' => $this->faker->randomElement(User::all()->where('role', User::STUDENT))->id,
            'cloth_id' => $this->faker->randomElement(Cloth::all())->id,
            'accessory_id' => $this->faker->randomElement(Accessory::all())->id,
            'status_code' => '0',
        ];
    }
}
