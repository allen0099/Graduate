<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'spec' => '白',
            'quantity' => 1050,
            'name' => '領巾、帽子',
            'type' => '學士',
        ]);
        DB::table('items')->insert([
            'spec' => '藍',
            'quantity' => 480,
            'name' => '領巾、帽子',
            'type' => '學士',
        ]);
        DB::table('items')->insert([
            'spec' => '白',
            'quantity' => 25,
            'name' => '披肩、帽穗',
            'type' => '碩士',
        ]);
        DB::table('items')->insert([
            'spec' => '黃',
            'quantity' => 20,
            'name' => '披肩、帽穗',
            'type' => '碩士',
        ]);
        DB::table('items')->insert([
            'spec' => '橘',
            'quantity' => 30,
            'name' => '披肩、帽穗',
            'type' => '碩士',
        ]);
        DB::table('items')->insert([
            'spec' => '灰',
            'quantity' => 300,
            'name' => '披肩、帽穗',
            'type' => '碩士',
        ]);
        DB::table('items')->insert([
            'spec' => '藍',
            'quantity' => 100,
            'name' => '披肩、帽穗',
            'type' => '碩士',
        ]);
        DB::table('items')->insert([
            'spec' => '紫',
            'quantity' => 50,
            'name' => '披肩、帽穗',
            'type' => '碩士',
        ]);
        DB::table('items')->insert([
            'type' => '學士',
            'name' => '學士服',
            'spec' => 'S',
            'quantity' => 330,
        ]);
        DB::table('items')->insert([
            'type' => '學士',
            'name' => '學士服',
            'spec' => 'M',
            'quantity' => 520,
        ]);
        DB::table('items')->insert([
            'type' => '學士',
            'name' => '學士服',
            'spec' => 'L',
            'quantity' => 420,
        ]);
        DB::table('items')->insert([
            'type' => '學士',
            'name' => '學士服',
            'spec' => 'XL',
            'quantity' => 210,
        ]);
        DB::table('items')->insert([
            'type' => '碩士',
            'name' => '碩士服',
            'spec' => 'M',
            'quantity' => 220,
        ]);
        DB::table('items')->insert([
            'type' => '碩士',
            'name' => '碩士服',
            'spec' => 'L',
            'quantity' => 190,
        ]);
        DB::table('items')->insert([
            'type' => '碩士',
            'name' => '碩士服',
            'spec' => 'XL',
            'quantity' => 160,
        ]);
        DB::table('items')->insert([
            'type' => '博士',
            'name' => '博士服',
            'spec' => 'S',
            'quantity' => 0,
        ]);
        DB::table('items')->insert([
            'type' => '博士',
            'name' => '博士服',
            'spec' => 'M',
            'quantity' => 129,
        ]);
        DB::table('items')->insert([
            'type' => '博士',
            'name' => '博士服',
            'spec' => 'L',
            'quantity' => 36,
        ]);
        DB::table('items')->insert([
            'type' => '博士',
            'name' => '博士服',
            'spec' => 'XL',
            'quantity' => 0,
        ]);
    }
}
