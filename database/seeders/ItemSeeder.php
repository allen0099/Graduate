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
            'name' => '領巾',
            'type' => '學士',
            'price' => 150,
        ]);
        DB::table('items')->insert([
            'spec' => '藍',
            'quantity' => 480,
            'name' => '領巾',
            'type' => '學士',
            'price' => 150,
        ]);
        DB::table('items')->insert([
            'spec' => '白',
            'quantity' => 25,
            'name' => '披肩、帽穗',
            'type' => '碩士',
            'price' => 150,
        ]);
        DB::table('items')->insert([
            'spec' => '黃',
            'quantity' => 20,
            'name' => '披肩、帽穗',
            'type' => '碩士',
            'price' => 150,
        ]);
        DB::table('items')->insert([
            'spec' => '橘',
            'quantity' => 30,
            'name' => '披肩、帽穗',
            'type' => '碩士',
            'price' => 150,
        ]);
        DB::table('items')->insert([
            'spec' => '灰',
            'quantity' => 300,
            'name' => '披肩、帽穗',
            'type' => '碩士',
            'price' => 150,
        ]);
        DB::table('items')->insert([
            'spec' => '藍',
            'quantity' => 100,
            'name' => '披肩、帽穗',
            'type' => '碩士',
            'price' => 150,
        ]);
        DB::table('items')->insert([
            'spec' => '紫',
            'quantity' => 50,
            'name' => '披肩、帽穗',
            'type' => '碩士',
            'price' => 150,
        ]);
        DB::table('items')->insert([
            'type' => '學士',
            'name' => '學士服',
            'spec' => 'S',
            'quantity' => 330,
            'price' => 500,
        ]);
        DB::table('items')->insert([
            'type' => '學士',
            'name' => '學士服',
            'spec' => 'M',
            'quantity' => 520,
            'price' => 500,
        ]);
        DB::table('items')->insert([
            'type' => '學士',
            'name' => '學士服',
            'spec' => 'L',
            'quantity' => 420,
            'price' => 500,
        ]);
        DB::table('items')->insert([
            'type' => '學士',
            'name' => '學士服',
            'spec' => 'XL',
            'quantity' => 210,
            'price' => 500,
        ]);
        DB::table('items')->insert([
            'type' => '碩士',
            'name' => '碩士服',
            'spec' => 'M',
            'quantity' => 220,
            'price' => 500,
        ]);
        DB::table('items')->insert([
            'type' => '碩士',
            'name' => '碩士服',
            'spec' => 'L',
            'quantity' => 190,
            'price' => 500,
        ]);
        DB::table('items')->insert([
            'type' => '碩士',
            'name' => '碩士服',
            'spec' => 'XL',
            'quantity' => 160,
            'price' => 500,
        ]);
        DB::table('items')->insert([
            'type' => '博士',
            'name' => '博士服',
            'spec' => 'S',
            'quantity' => 0,
            'price' => 500,
        ]);
        DB::table('items')->insert([
            'type' => '博士',
            'name' => '博士服',
            'spec' => 'M',
            'quantity' => 129,
            'price' => 500,
        ]);
        DB::table('items')->insert([
            'type' => '博士',
            'name' => '博士服',
            'spec' => 'L',
            'quantity' => 36,
            'price' => 500,
        ]);
        DB::table('items')->insert([
            'type' => '博士',
            'name' => '博士服',
            'spec' => 'XL',
            'quantity' => 0,
            'price' => 500,
        ]);
    }
}
