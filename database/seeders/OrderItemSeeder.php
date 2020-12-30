<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            OrderItem::factory()->create();
        }
        for ($i = 0; $i < 10; $i++) {
            OrderItem::factory()
                ->appendData()
                ->create();
        }
    }
}
