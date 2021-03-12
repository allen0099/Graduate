<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->admin()
            ->create([
                'name' => '管理員',
                'username' => 'tku_admin',
            ]);
        User::factory()
            ->admin()
            ->create([
                'name' => 'Tkuosc',
                'username' => 'tkuosc',
            ]);

        User::factory()
            ->student()
            ->create([
                'name' => '學生一',
                'username' => '406410000',          // 預設帳號
            ]);
        User::factory()
            ->student()
            ->create([
                'name' => '學生二',
                'username' => '406410001',          // 預設帳號
            ]);
        User::factory()
            ->count(25)
            ->student()
            ->create();
    }
}
