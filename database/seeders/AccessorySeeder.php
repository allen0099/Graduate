<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accessories')->insert([
            'color' => '白',
            'quantity' => 1050,
            'name' => '領巾',
            'type' => '學士']);
        DB::table('accessories')->insert([
            'color' => '藍',
            'quantity' => 480,
            'name' => '領巾',
            'type' => '學士']);
        DB::table('accessories')->insert([
            'color' => '白',
            'quantity' => 25,
            'name' => '披肩、帽穗',
            'type' => '碩士']);
        DB::table('accessories')->insert([
            'color' => '黃',
            'quantity' => 20,
            'name' => '披肩、帽穗',
            'type' => '碩士']);
        DB::table('accessories')->insert([
            'color' => '橘',
            'quantity' => 30,
            'name' => '披肩、帽穗',
            'type' => '碩士']);
        DB::table('accessories')->insert([
            'color' => '灰',
            'quantity' => 300,
            'name' => '披肩、帽穗',
            'type' => '碩士']);
        DB::table('accessories')->insert([
            'color' => '藍',
            'quantity' => 100,
            'name' => '披肩、帽穗',
            'type' => '碩士']);
        DB::table('accessories')->insert([
            'color' => '紫',
            'quantity' => 50,
            'name' => '披肩、帽穗',
            'type' => '碩士']);
    }
}
