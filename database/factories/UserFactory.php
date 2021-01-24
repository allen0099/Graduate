<?php

namespace Database\Factories;

use App\Models\DepartmentClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ];
    }

    public function admin()
    {
        return $this->state(fn(array $attributes) => [
            'username' => 'admin' . str_pad($this->faker->unique()->numberBetween($min = 0, $max = 9999), 4, '0', STR_PAD_LEFT),  // 預設帳號
            'email' => fn(array $attributes) => $attributes['username'] . '@aaa.aaa',
            'role' => User::ADMIN,
            'stamp' => ''
        ]);
    }

    public function student()
    {
        return $this->state(fn(array $attributes) => [
            'username' => '40641' . str_pad($this->faker->unique()->numberBetween($min = 2, $max = 9999), 4, '0', STR_PAD_LEFT),          // 預設帳號
            'email' => fn(array $attributes) => $attributes['username'] . '@gms.tku.edu.tw',
            'role' => User::STUDENT,
            'class_id' => $this->faker->randomElement(DepartmentClass::all())->id,
        ]);
    }
}
