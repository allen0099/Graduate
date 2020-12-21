<?php

namespace Database\Factories;

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
            'username' => 'admin' . $this->faker->unique()->numberBetween($min = 1000, $max = 9999),  // 預設帳號
            'email' => fn(array $attributes) => $attributes['username'] . '@aaa.aaa',
            'role' => User::ADMIN,
            'stamp' => ''
        ]);
    }

    public function student()
    {
        return $this->state(fn(array $attributes) => [
            'username' => '40641' . $this->faker->unique()->numberBetween($min = 1000, $max = 9999),          // 預設帳號
            'email' => fn(array $attributes) => $attributes['username'] . '@gms.tku.edu.tw',
            'role' => User::STUDENT,
            'school_year_id' => 1,
            'department_id' => 25,
            'grade' => '四',
            'class' => $this->faker->randomElement(['A', 'B', 'C'])
        ]);
    }
}
