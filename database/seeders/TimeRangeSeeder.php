<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('time_ranges')->insert([
            'content' => '借用時間',
            'start_time' => today()->startOfDay(),
            'end_time' => today()->endOfDay(),
        ]);
        DB::table('time_ranges')->insert([
            'content' => '繳費期限',
            'start_time' => today()->startOfDay(),
            'end_time' => today()->endOfDay(),
        ]);
        DB::table('time_ranges')->insert([
            'content' => '領取時間(學士服)',
            'start_time' => today()->startOfDay(),
            'end_time' => today()->endOfDay(),
        ]);
        DB::table('time_ranges')->insert([
            'content' => '領取時間(碩士服)',
            'start_time' => today()->startOfDay(),
            'end_time' => today()->endOfDay(),
        ]);
        DB::table('time_ranges')->insert([
            'content' => '歸還期限',
            'start_time' => today()->startOfDay(),
            'end_time' => today()->endOfDay(),
        ]);
    }
}
