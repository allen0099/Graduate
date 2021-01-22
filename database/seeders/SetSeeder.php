<?php

namespace Database\Seeders;

use App\Models\Set;
use Illuminate\Database\Seeder;

class SetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Set::factory()->create();
        }
        for ($i = 0; $i < 10; $i++) {
            Set::factory()
                ->appendData()
                ->create();
        }
    }
}
