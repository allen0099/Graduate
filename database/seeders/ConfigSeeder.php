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
            'key' => '付款地點',
            'value' => '守謙會議中心HC308事務整備組',
        ]);
        DB::table('configs')->insert([
            'key' => '領取地點',
            'value' => '覺生紀念圖書館正門入口前左側',
        ]);
        DB::table('configs')->insert([
            'key' => '歸還地點',
            'value' => '守謙會議中心HC308事務整備組',
        ]);
        DB::table('configs')->insert([
            'key' => 'bachelor_price',
            'value' => '100',
        ]);
        DB::table('configs')->insert([
            'key' => 'master_price',
            'value' => '200',
        ]);
        DB::table('configs')->insert([
            'key' => 'bachelor_margin_price',
            'value' => '500',
        ]);
        DB::table('configs')->insert([
            'key' => 'master_margin_price',
            'value' => '1000',
        ]);
        DB::table('configs')->insert([
            'key' => 'pdf_a',
            'value' => '109學年度學士學位服借用公告',
        ]);
        DB::table('configs')->insert([
            'key' => 'pdf_b',
            'value' => '使用說明',
        ]);
        DB::table('configs')->insert([
            'key' => 'pdf_c',
            'value' => '淡江大學學位服借用要點',
        ]);
        DB::table('configs')->insert([
            'key' => 'department_stamp',
            'value' => 'PX8LKEBveG4s24JFnMt9nf3pMRiCBO4p6xf4QDSm.jpg',
        ]);
        DB::table('configs')->insert([
            'key' => 'admin_stamp',
            'value' => 'IOauP3b5XUhtZ3IWLaiWllZ2muUziKWOZhNngrUt.jpg',
        ]);
    }
}
