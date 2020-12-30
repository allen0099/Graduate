<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            SchoolYearSeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,

            ItemSeeder::class,
            OrderItemSeeder::class,
            OrderShareSeeder::class,

            ConfigSeeder::class,
            TimeRangeSeeder::class,
        ]);
    }
}
