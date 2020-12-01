<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClothSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cloths')->insert([
            'type' => '學士',
            'size' => 'S',
            'quantity' => 330,
        ]);
        DB::table('cloths')->insert([
            'type' => '學士',
            'size' => 'M',
            'quantity' => 520,
        ]);
        DB::table('cloths')->insert([
            'type' => '學士',
            'size' => 'L',
            'quantity' => 420,
        ]);
        DB::table('cloths')->insert([
            'type' => '學士',
            'size' => 'XL',
            'quantity' => 210,
        ]);
        DB::table('cloths')->insert([
            'type' => '碩士',
            'size' => 'XL',
            'quantity' => 160,
        ]);
        DB::table('cloths')->insert([
            'type' => '碩士',
            'size' => 'L',
            'quantity' => 190,
        ]);
        DB::table('cloths')->insert([
            'type' => '碩士',
            'size' => 'M',
            'quantity' => 220,
        ]);
        DB::table('cloths')->insert([
            'type' => '博士',
            'size' => 'S',
            'quantity' => 0,
        ]);
        DB::table('cloths')->insert([
            'type' => '博士',
            'size' => 'M',
            'quantity' => 129,
        ]);
        DB::table('cloths')->insert([
            'type' => '博士',
            'size' => 'L',
            'quantity' => 36,
        ]);
        DB::table('cloths')->insert([
            'type' => '博士',
            'size' => 'XL',
            'quantity' => 0,
        ]);
    }
}
