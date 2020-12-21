<?php

namespace Database\Seeders;

use App\Models\OrderShare;
use Illuminate\Database\Seeder;

class OrderShareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 15; $i++) {
            OrderShare::factory()->create();
        }
    }
}
