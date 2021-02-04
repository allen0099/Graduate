<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'key' => '歸還地點',
            'value' => '守謙會議中心HC308事務整備組',
        ]);
        DB::table('configs')->insert([
            'key' => 'bachelor_price',
            'value' => '400',
        ]);
        DB::table('configs')->insert([
            'key' => 'master_price',
            'value' => '600',
        ]);
        DB::table('configs')->insert([
            'key' => 'master_margin_price',
            'value' => '800',
        ]);
        DB::table('configs')->insert([
            'key' => 'bachelor_margin_price',
            'value' => '500',
        ]);
    }
}
