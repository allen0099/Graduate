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
            'value' => '守謙會議中心 HC308',
        ]);
        DB::table('configs')->insert([
            'key' => 'bachelor_set_price',
            'value' => '900',
        ]);
        DB::table('configs')->insert([
            'key' => 'master_set_price',
            'value' => '1300',
        ]);
        DB::table('configs')->insert([
            'key' => 'margin_price',
            'value' => '200',
        ]);
    }
}
