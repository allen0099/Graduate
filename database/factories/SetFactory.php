<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Order;
use App\Models\Set;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Set::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $student = User::all()
            ->where('role', User::STUDENT)
            ->whereNotIn('id', Set::getHaveSetIds());

        $color_item = Item::accessories();
        $size_item = Item::clothes();
        return [
            'student_id' => $this->faker->randomElement($student)->id,
            'order_id' => Order::factory(),
            'color_item' => $this->faker->randomElement($color_item)->id,
            'size_item' => $this->faker->randomElement($size_item)->id
        ];
    }

    public function appendData()
    {
        $order = Order::all();
        return $this->state(fn(array $attributes) => [
            'order_id' => $this->faker->randomElement($order)->id,
        ]);
    }
}
