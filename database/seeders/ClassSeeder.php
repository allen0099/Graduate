<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('department_classes')->insert([
            'department_id' => 1,
            'class_id' => 'TABAJ2',
            'class_name' => '資圖二數碩專',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 1,
            'class_id' => 'TABAJ3',
            'class_name' => '資圖三數碩專',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 1,
            'class_id' => 'TABAJ4',
            'class_name' => '資圖四數碩專',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 2,
            'class_id' => 'TABXB4A',
            'class_name' => '資圖四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 2,
            'class_id' => 'TABXB4B',
            'class_name' => '資圖四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 2,
            'class_id' => 'TABXM2',
            'class_name' => '資圖二碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 2,
            'class_id' => 'TABXM3',
            'class_name' => '資圖三碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 2,
            'class_id' => 'TABXM4',
            'class_name' => '資圖四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 3,
            'class_id' => 'TACAM4',
            'class_name' => '中文碩文學四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 4,
            'class_id' => 'TACBM4',
            'class_name' => '中文碩語言四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXB4A',
            'class_name' => '中文四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXB4B',
            'class_name' => '中文四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXD2',
            'class_name' => '中文二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXD3',
            'class_name' => '中文三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXD4',
            'class_name' => '中文四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXD5',
            'class_name' => '中文五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXD6',
            'class_name' => '中文六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXD7',
            'class_name' => '中文七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXE4',
            'class_name' => '中文進學班四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXJ2',
            'class_name' => '中文二碩專班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXJ3',
            'class_name' => '中文三碩專班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXJ4',
            'class_name' => '中文四碩專班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXM2',
            'class_name' => '中文二碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXM3',
            'class_name' => '中文三碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 5,
            'class_id' => 'TACXM4',
            'class_name' => '中文四碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 6,
            'class_id' => 'TAHXB4A',
            'class_name' => '歷史四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 6,
            'class_id' => 'TAHXB4B',
            'class_name' => '歷史四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 6,
            'class_id' => 'TAHXM2',
            'class_name' => '歷史二碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 6,
            'class_id' => 'TAHXM3',
            'class_name' => '歷史三碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 6,
            'class_id' => 'TAHXM4',
            'class_name' => '歷史四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 7,
            'class_id' => 'TAIXB4A',
            'class_name' => '資傳四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 7,
            'class_id' => 'TAIXB4B',
            'class_name' => '資傳四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 7,
            'class_id' => 'TAIXM4',
            'class_name' => '資傳四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 8,
            'class_id' => 'TAMAM2',
            'class_name' => '大傳二碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 8,
            'class_id' => 'TAMAM3',
            'class_name' => '大傳三碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 8,
            'class_id' => 'TAMAM4',
            'class_name' => '大傳四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 9,
            'class_id' => 'TAMXB4',
            'class_name' => '大傳四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 10,
            'class_id' => 'TDCXM2',
            'class_name' => '教心二碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 10,
            'class_id' => 'TDCXM3',
            'class_name' => '教心三碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 10,
            'class_id' => 'TDCXM4',
            'class_name' => '教心四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 11,
            'class_id' => 'TDDXM2',
            'class_name' => '未來二碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 11,
            'class_id' => 'TDDXM3',
            'class_name' => '未來三碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 11,
            'class_id' => 'TDDXM4',
            'class_name' => '未來四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 12,
            'class_id' => 'TDIXJ2',
            'class_name' => '課程二碩專班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 12,
            'class_id' => 'TDIXJ3',
            'class_name' => '課程三碩專班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 12,
            'class_id' => 'TDIXJ4',
            'class_name' => '課程四碩專班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 12,
            'class_id' => 'TDIXM2',
            'class_name' => '課程二碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 12,
            'class_id' => 'TDIXM3',
            'class_name' => '課程三碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 12,
            'class_id' => 'TDIXM4',
            'class_name' => '課程四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 14,
            'class_id' => 'TDPXJ3',
            'class_name' => '教政三碩專班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 14,
            'class_id' => 'TDPXJ4',
            'class_name' => '教政四碩專班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 14,
            'class_id' => 'TDPXM2',
            'class_name' => '教政二碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 14,
            'class_id' => 'TDPXM3',
            'class_name' => '教政三碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 14,
            'class_id' => 'TDPXM4',
            'class_name' => '教政四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 15,
            'class_id' => 'TDTAJ2',
            'class_name' => '教科二數碩專',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 15,
            'class_id' => 'TDTAJ3',
            'class_name' => '教科三數碩專',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 15,
            'class_id' => 'TDTAJ4',
            'class_name' => '教科四數碩專',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 16,
            'class_id' => 'TDTXB4A',
            'class_name' => '教科四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 16,
            'class_id' => 'TDTXB4B',
            'class_name' => '教科四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 16,
            'class_id' => 'TDTXJ2',
            'class_name' => '教科二碩專班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 16,
            'class_id' => 'TDTXJ3',
            'class_name' => '教科三碩專班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 16,
            'class_id' => 'TDTXJ4',
            'class_name' => '教科四碩專班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 16,
            'class_id' => 'TDTXM2',
            'class_name' => '教科二碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 16,
            'class_id' => 'TDTXM3',
            'class_name' => '教科三碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 16,
            'class_id' => 'TDTXM4',
            'class_name' => '教科四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 94,
            'class_id' => 'TDXXD2',
            'class_name' => '教管二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 94,
            'class_id' => 'TDXXD3',
            'class_name' => '教管三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 94,
            'class_id' => 'TDXXD4',
            'class_name' => '教管四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 94,
            'class_id' => 'TDXXD5',
            'class_name' => '教管五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 94,
            'class_id' => 'TDXXD6',
            'class_name' => '教管六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 94,
            'class_id' => 'TDXXD7',
            'class_name' => '教管七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 17,
            'class_id' => 'TEAXB5',
            'class_name' => '建築五',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 17,
            'class_id' => 'TEAXM2',
            'class_name' => '建築二碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 17,
            'class_id' => 'TEAXM3',
            'class_name' => '建築三碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 17,
            'class_id' => 'TEAXM4',
            'class_name' => '建築四碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 18,
            'class_id' => 'TEBAB4',
            'class_name' => '機械系光機四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 18,
            'class_id' => 'TEBAM4',
            'class_name' => '機械四光機碩',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 19,
            'class_id' => 'TEBBB4',
            'class_name' => '機械系精密四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 19,
            'class_id' => 'TEBBM4',
            'class_name' => '機械四精密碩',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 20,
            'class_id' => 'TEBXD2',
            'class_name' => '機械二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 20,
            'class_id' => 'TEBXD3',
            'class_name' => '機械三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 20,
            'class_id' => 'TEBXD5',
            'class_name' => '機械五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 20,
            'class_id' => 'TEBXD6',
            'class_name' => '機械六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 20,
            'class_id' => 'TEBXD7',
            'class_name' => '機械七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 20,
            'class_id' => 'TEBXM2',
            'class_name' => '機械二碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 20,
            'class_id' => 'TEBXM4',
            'class_name' => '機械四碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 21,
            'class_id' => 'TECAB4A',
            'class_name' => '土木工設四Ａ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 21,
            'class_id' => 'TECAB4B',
            'class_name' => '土木工設四Ｂ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 22,
            'class_id' => 'TECBB4',
            'class_name' => '土木系營企四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 23,
            'class_id' => 'TECXD2',
            'class_name' => '土木二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 23,
            'class_id' => 'TECXD3',
            'class_name' => '土木三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 23,
            'class_id' => 'TECXD4',
            'class_name' => '土木四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 23,
            'class_id' => 'TECXD5',
            'class_name' => '土木五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 23,
            'class_id' => 'TECXD6',
            'class_name' => '土木六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 23,
            'class_id' => 'TECXD7',
            'class_name' => '土木七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 23,
            'class_id' => 'TECXM2',
            'class_name' => '土木二碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 23,
            'class_id' => 'TECXM3',
            'class_name' => '土木三碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 23,
            'class_id' => 'TECXM4',
            'class_name' => '土木四碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 24,
            'class_id' => 'TEDXB4A',
            'class_name' => '化材四Ａ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 24,
            'class_id' => 'TEDXB4B',
            'class_name' => '化材四Ｂ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 24,
            'class_id' => 'TEDXD3',
            'class_name' => '化材三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 24,
            'class_id' => 'TEDXD4',
            'class_name' => '化材四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 24,
            'class_id' => 'TEDXD5',
            'class_name' => '化材五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 24,
            'class_id' => 'TEDXD6',
            'class_name' => '化材六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 24,
            'class_id' => 'TEDXM2',
            'class_name' => '化材二碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 24,
            'class_id' => 'TEDXM3',
            'class_name' => '化材三碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 25,
            'class_id' => 'TEIBM2',
            'class_name' => '資工二全英碩',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 26,
            'class_id' => 'TEICM2',
            'class_name' => '資網二碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 26,
            'class_id' => 'TEICM3',
            'class_name' => '資網三碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 26,
            'class_id' => 'TEICM4',
            'class_name' => '資網四碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXB4A',
            'class_name' => '資工四Ａ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXB4B',
            'class_name' => '資工四Ｂ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXB4C',
            'class_name' => '資工四Ｃ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXD2',
            'class_name' => '資工二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXD3',
            'class_name' => '資工三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXD4',
            'class_name' => '資工四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXD5',
            'class_name' => '資工五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXD6',
            'class_name' => '資工六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXD7',
            'class_name' => '資工七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXE4',
            'class_name' => '資工進學班四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXJ2',
            'class_name' => '資工二碩專班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXJ3',
            'class_name' => '資工三碩專班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXJ4',
            'class_name' => '資工四碩專班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXM2',
            'class_name' => '資工二碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXM3',
            'class_name' => '資工三碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 27,
            'class_id' => 'TEIXM4',
            'class_name' => '資工四碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 28,
            'class_id' => 'TENXB4A',
            'class_name' => '航太四Ａ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 28,
            'class_id' => 'TENXB4B',
            'class_name' => '航太四Ｂ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 28,
            'class_id' => 'TENXJ2',
            'class_name' => '航太二碩專班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 28,
            'class_id' => 'TENXJ4',
            'class_name' => '航太四碩專班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 28,
            'class_id' => 'TENXM2',
            'class_name' => '航太二碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 28,
            'class_id' => 'TENXM3',
            'class_name' => '航太三碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 28,
            'class_id' => 'TENXM4',
            'class_name' => '航太四碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 29,
            'class_id' => 'TETBM2',
            'class_name' => '電機二電路組',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 29,
            'class_id' => 'TETBM3',
            'class_name' => '電機三電路組',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 30,
            'class_id' => 'TETCB4',
            'class_name' => '電機系電機四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 31,
            'class_id' => 'TETDB4',
            'class_name' => '電機系電資四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 31,
            'class_id' => 'TETDM2',
            'class_name' => '電機二控制組',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 31,
            'class_id' => 'TETDM3',
            'class_name' => '電機三控制組',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 32,
            'class_id' => 'TETEB4',
            'class_name' => '電機系電通四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 32,
            'class_id' => 'TETEM2',
            'class_name' => '電機二機器人',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 32,
            'class_id' => 'TETEM3',
            'class_name' => '電機三機器人',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 32,
            'class_id' => 'TETEM4',
            'class_name' => '電機四機器人',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 33,
            'class_id' => 'TETIM2',
            'class_name' => '電機二智聯組',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 33,
            'class_id' => 'TETIM3',
            'class_name' => '電機三智聯組',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 33,
            'class_id' => 'TETIM4',
            'class_name' => '電機四智聯組',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 34,
            'class_id' => 'TETXD2',
            'class_name' => '電機二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 34,
            'class_id' => 'TETXD3',
            'class_name' => '電機三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 34,
            'class_id' => 'TETXD4',
            'class_name' => '電機四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 34,
            'class_id' => 'TETXD5',
            'class_name' => '電機五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 34,
            'class_id' => 'TETXD6',
            'class_name' => '電機六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 34,
            'class_id' => 'TETXD7',
            'class_name' => '電機七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 34,
            'class_id' => 'TETXE4',
            'class_name' => '電機進學班四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 34,
            'class_id' => 'TETXJ2',
            'class_name' => '電機二碩專班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 34,
            'class_id' => 'TETXJ3',
            'class_name' => '電機三碩專班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 34,
            'class_id' => 'TETXJ4',
            'class_name' => '電機四碩專班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 35,
            'class_id' => 'TEWAB4',
            'class_name' => '水環水資源四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 36,
            'class_id' => 'TEWBB4',
            'class_name' => '水環系環工四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 37,
            'class_id' => 'TEWXD2',
            'class_name' => '水環二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 37,
            'class_id' => 'TEWXD3',
            'class_name' => '水環三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 37,
            'class_id' => 'TEWXD4',
            'class_name' => '水環四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 37,
            'class_id' => 'TEWXD5',
            'class_name' => '水環五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 37,
            'class_id' => 'TEWXD6',
            'class_name' => '水環六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 37,
            'class_id' => 'TEWXD7',
            'class_name' => '水環七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 37,
            'class_id' => 'TEWXM2',
            'class_name' => '水環二碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 37,
            'class_id' => 'TEWXM3',
            'class_name' => '水環三碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 37,
            'class_id' => 'TEWXM4',
            'class_name' => '水環四碩士班',
            'default_color' => '橘',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 95,
            'class_id' => 'TEXAD2',
            'class_name' => '機器人二博班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 95,
            'class_id' => 'TEXAD3',
            'class_name' => '機器人三博班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 95,
            'class_id' => 'TEXAD4',
            'class_name' => '機器人四博班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 38,
            'class_id' => 'TFFXB4A',
            'class_name' => '法文四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 38,
            'class_id' => 'TFFXB4B',
            'class_name' => '法文四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 38,
            'class_id' => 'TFFXM2',
            'class_name' => '法文二碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 38,
            'class_id' => 'TFFXM3',
            'class_name' => '法文三碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 38,
            'class_id' => 'TFFXM4',
            'class_name' => '法文四碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 39,
            'class_id' => 'TFGXB4',
            'class_name' => '德文四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 40,
            'class_id' => 'TFJXB4A',
            'class_name' => '日文四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 40,
            'class_id' => 'TFJXB4B',
            'class_name' => '日文四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 40,
            'class_id' => 'TFJXB4C',
            'class_name' => '日文四Ｃ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 40,
            'class_id' => 'TFJXE4',
            'class_name' => '日文進學班四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 40,
            'class_id' => 'TFJXJ2',
            'class_name' => '日文二碩專班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 40,
            'class_id' => 'TFJXJ3',
            'class_name' => '日文三碩專班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 40,
            'class_id' => 'TFJXJ4',
            'class_name' => '日文四碩專班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 40,
            'class_id' => 'TFJXM2',
            'class_name' => '日文二碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 40,
            'class_id' => 'TFJXM3',
            'class_name' => '日文三碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 40,
            'class_id' => 'TFJXM4',
            'class_name' => '日文四碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXB4A',
            'class_name' => '英文四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXB4B',
            'class_name' => '英文四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXB4C',
            'class_name' => '英文四Ｃ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXD2',
            'class_name' => '英文二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXD3',
            'class_name' => '英文三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXD4',
            'class_name' => '英文四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXD5',
            'class_name' => '英文五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXD6',
            'class_name' => '英文六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXD7',
            'class_name' => '英文七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXE4',
            'class_name' => '英文進學班四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXM2',
            'class_name' => '英文二碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXM3',
            'class_name' => '英文三碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 41,
            'class_id' => 'TFLXM4',
            'class_name' => '英文四碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 42,
            'class_id' => 'TFSXB4A',
            'class_name' => '西語四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 42,
            'class_id' => 'TFSXB4B',
            'class_name' => '西語四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 42,
            'class_id' => 'TFSXM4',
            'class_name' => '西語四碩士班',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 43,
            'class_id' => 'TFUXB4',
            'class_name' => '俄文四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 44,
            'class_id' => 'TLAXB4A',
            'class_name' => '會計四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 44,
            'class_id' => 'TLAXB4B',
            'class_name' => '會計四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 44,
            'class_id' => 'TLAXE4',
            'class_name' => '會計進學班四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 44,
            'class_id' => 'TLAXJ2',
            'class_name' => '會計二碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 44,
            'class_id' => 'TLAXJ3',
            'class_name' => '會計三碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 44,
            'class_id' => 'TLAXJ4',
            'class_name' => '會計四碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 44,
            'class_id' => 'TLAXM2',
            'class_name' => '會計二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 44,
            'class_id' => 'TLAXM3',
            'class_name' => '會計三碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXB4A',
            'class_name' => '財金四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXB4B',
            'class_name' => '財金四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXD2',
            'class_name' => '財金二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXD3',
            'class_name' => '財金三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXD4',
            'class_name' => '財金四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXD5',
            'class_name' => '財金五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXD6',
            'class_name' => '財金六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXD7',
            'class_name' => '財金七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXE4',
            'class_name' => '財金進學班四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXJ2',
            'class_name' => '財金二碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXJ3',
            'class_name' => '財金三碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXJ4',
            'class_name' => '財金四碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXM2',
            'class_name' => '財金二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXM3',
            'class_name' => '財金三碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXM3A',
            'class_name' => '金三Ａ碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 45,
            'class_id' => 'TLBXM3B',
            'class_name' => '金三Ｂ碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 46,
            'class_id' => 'TLCXB4A',
            'class_name' => '企管四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 46,
            'class_id' => 'TLCXB4B',
            'class_name' => '企管四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 46,
            'class_id' => 'TLCXE4A',
            'class_name' => '企管進四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 46,
            'class_id' => 'TLCXE4B',
            'class_name' => '企管進四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 46,
            'class_id' => 'TLCXJ2',
            'class_name' => '企管二碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 46,
            'class_id' => 'TLCXJ3',
            'class_name' => '企管三碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 46,
            'class_id' => 'TLCXJ4',
            'class_name' => '企管四碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 46,
            'class_id' => 'TLCXM2',
            'class_name' => '企管二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 46,
            'class_id' => 'TLCXM3',
            'class_name' => '企管三碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 46,
            'class_id' => 'TLCXM4',
            'class_name' => '企管四碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 47,
            'class_id' => 'TLEXB4A',
            'class_name' => '產經四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 47,
            'class_id' => 'TLEXB4B',
            'class_name' => '產經四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 47,
            'class_id' => 'TLEXD2',
            'class_name' => '產經二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 47,
            'class_id' => 'TLEXD3',
            'class_name' => '產經三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 47,
            'class_id' => 'TLEXD4',
            'class_name' => '產經四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 47,
            'class_id' => 'TLEXD5',
            'class_name' => '產經五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 47,
            'class_id' => 'TLEXD6',
            'class_name' => '產經六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 47,
            'class_id' => 'TLEXD7',
            'class_name' => '產經七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 47,
            'class_id' => 'TLEXM2',
            'class_name' => '產經二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 47,
            'class_id' => 'TLEXM4',
            'class_name' => '產經四碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 48,
            'class_id' => 'TLFAB4',
            'class_name' => '國企系經管四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 48,
            'class_id' => 'TLFAJ2',
            'class_name' => '國行二碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 48,
            'class_id' => 'TLFAJ3',
            'class_name' => '國行三碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 48,
            'class_id' => 'TLFAJ4',
            'class_name' => '國行四碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 49,
            'class_id' => 'TLFBB4',
            'class_name' => '國企系國商四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 49,
            'class_id' => 'TLFBJ2',
            'class_name' => '國創二碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 49,
            'class_id' => 'TLFBJ3',
            'class_name' => '國創三碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 50,
            'class_id' => 'TLFXB4A',
            'class_name' => '國企四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 50,
            'class_id' => 'TLFXB4B',
            'class_name' => '國企四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 50,
            'class_id' => 'TLFXE4',
            'class_name' => '國企系進學四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 50,
            'class_id' => 'TLFXM2',
            'class_name' => '國企二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 50,
            'class_id' => 'TLFXM3',
            'class_name' => '國企三碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 50,
            'class_id' => 'TLFXM4',
            'class_name' => '國企四碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 51,
            'class_id' => 'TLGAM2',
            'class_name' => '管科企經碩二',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 51,
            'class_id' => 'TLGAM3',
            'class_name' => '管科企經碩三',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 51,
            'class_id' => 'TLGAM4',
            'class_name' => '管科企經碩四',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 52,
            'class_id' => 'TLGXB4A',
            'class_name' => '管科四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 52,
            'class_id' => 'TLGXB4B',
            'class_name' => '管科四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 52,
            'class_id' => 'TLGXD2',
            'class_name' => '管科二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 52,
            'class_id' => 'TLGXD3',
            'class_name' => '管科三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 52,
            'class_id' => 'TLGXD4',
            'class_name' => '管科四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 52,
            'class_id' => 'TLGXD5',
            'class_name' => '管科五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 52,
            'class_id' => 'TLGXD6',
            'class_name' => '管科六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 52,
            'class_id' => 'TLGXD7',
            'class_name' => '管科七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 52,
            'class_id' => 'TLGXJ2',
            'class_name' => '管科二碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 52,
            'class_id' => 'TLGXJ4',
            'class_name' => '管科四碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 53,
            'class_id' => 'TLMXB4A',
            'class_name' => '資管四Ａ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 53,
            'class_id' => 'TLMXB4B',
            'class_name' => '資管四Ｂ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 53,
            'class_id' => 'TLMXB4C',
            'class_name' => '資管四Ｃ',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 53,
            'class_id' => 'TLMXJ2',
            'class_name' => '資管二碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 53,
            'class_id' => 'TLMXJ3',
            'class_name' => '資管三碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 53,
            'class_id' => 'TLMXJ4',
            'class_name' => '資管四碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 53,
            'class_id' => 'TLMXM2',
            'class_name' => '資管二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 53,
            'class_id' => 'TLMXM3',
            'class_name' => '資管三碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 53,
            'class_id' => 'TLMXM4',
            'class_name' => '資管四碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 54,
            'class_id' => 'TLOXB4A',
            'class_name' => '風保四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 54,
            'class_id' => 'TLOXB4B',
            'class_name' => '風保四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 54,
            'class_id' => 'TLOXJ2',
            'class_name' => '風保二碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 54,
            'class_id' => 'TLOXJ3',
            'class_name' => '風保三碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 54,
            'class_id' => 'TLOXJ4',
            'class_name' => '風保四碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 54,
            'class_id' => 'TLOXM2',
            'class_name' => '風保二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 54,
            'class_id' => 'TLOXM3',
            'class_name' => '風保三碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 54,
            'class_id' => 'TLOXM4',
            'class_name' => '風保四碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 55,
            'class_id' => 'TLPXB4A',
            'class_name' => '公行四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 55,
            'class_id' => 'TLPXB4B',
            'class_name' => '公行四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 55,
            'class_id' => 'TLPXE4',
            'class_name' => '公行進學班四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 55,
            'class_id' => 'TLPXJ2',
            'class_name' => '公行二碩專班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 55,
            'class_id' => 'TLPXJ3',
            'class_name' => '公行三碩專班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 55,
            'class_id' => 'TLPXJ4',
            'class_name' => '公行四碩專班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 55,
            'class_id' => 'TLPXM2',
            'class_name' => '公行二碩士班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 55,
            'class_id' => 'TLPXM3',
            'class_name' => '公行三碩士班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 55,
            'class_id' => 'TLPXM4',
            'class_name' => '公行四碩士班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 56,
            'class_id' => 'TLQXM2',
            'class_name' => '經營管理碩二',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 56,
            'class_id' => 'TLQXM3',
            'class_name' => '經營管理碩三',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 57,
            'class_id' => 'TLSXB4A',
            'class_name' => '統計四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 57,
            'class_id' => 'TLSXB4B',
            'class_name' => '統計四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 57,
            'class_id' => 'TLSXB4C',
            'class_name' => '統計四Ｃ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 57,
            'class_id' => 'TLSXE4',
            'class_name' => '統計進學班四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 57,
            'class_id' => 'TLSXM2',
            'class_name' => '統計二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 57,
            'class_id' => 'TLSXM4',
            'class_name' => '統計四碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 58,
            'class_id' => 'TLTXB4A',
            'class_name' => '運管四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 58,
            'class_id' => 'TLTXB4B',
            'class_name' => '運管四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 58,
            'class_id' => 'TLTXM2',
            'class_name' => '運管二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 58,
            'class_id' => 'TLTXM3',
            'class_name' => '運管三碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 58,
            'class_id' => 'TLTXM4',
            'class_name' => '運管四碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 59,
            'class_id' => 'TLUXM2',
            'class_name' => '財金雙碩士二',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 59,
            'class_id' => 'TLUXM3',
            'class_name' => '財金雙碩士三',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 59,
            'class_id' => 'TLUXM4',
            'class_name' => '財金雙碩士四',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 60,
            'class_id' => 'TLVXM2',
            'class_name' => '數商經濟碩二',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 61,
            'class_id' => 'TLWXB4',
            'class_name' => '全財管學程四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 62,
            'class_id' => 'TLXDM2',
            'class_name' => '大數據碩二',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 62,
            'class_id' => 'TLXDM3',
            'class_name' => '大數據碩三',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 62,
            'class_id' => 'TLXDM4',
            'class_name' => '大數據碩四',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 96,
            'class_id' => 'TLXED3',
            'class_name' => '商管金融博三',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 63,
            'class_id' => 'TLYAM2',
            'class_name' => '經濟二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 63,
            'class_id' => 'TLYAM3',
            'class_name' => '經濟三碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 63,
            'class_id' => 'TLYAM4',
            'class_name' => '經濟四碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 64,
            'class_id' => 'TLYXB4A',
            'class_name' => '經濟四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 64,
            'class_id' => 'TLYXB4B',
            'class_name' => '經濟四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 64,
            'class_id' => 'TLYXB4C',
            'class_name' => '經濟四Ｃ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 65,
            'class_id' => 'TQAXB4',
            'class_name' => '語言四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 66,
            'class_id' => 'TQGXB4',
            'class_name' => '政經四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 67,
            'class_id' => 'TQICB4',
            'class_name' => '資創系軟工四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 68,
            'class_id' => 'TQIDB4',
            'class_name' => '資創系應資四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 69,
            'class_id' => 'TQTXB4A',
            'class_name' => '觀光四Ａ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 69,
            'class_id' => 'TQTXB4B',
            'class_name' => '觀光四Ｂ',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 70,
            'class_id' => 'TRCBM3',
            'class_name' => '大陸三經貿組',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 70,
            'class_id' => 'TRCBM4',
            'class_name' => '大陸四經貿組',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 71,
            'class_id' => 'TRCCM3',
            'class_name' => '大陸三政社組',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 71,
            'class_id' => 'TRCCM4',
            'class_name' => '大陸四政社組',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 72,
            'class_id' => 'TRCXJ2',
            'class_name' => '大陸二碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 72,
            'class_id' => 'TRCXJ3',
            'class_name' => '大陸三碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 72,
            'class_id' => 'TRCXJ4',
            'class_name' => '大陸四碩專班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 72,
            'class_id' => 'TRCXM2',
            'class_name' => '大陸二碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 72,
            'class_id' => 'TRCXM3',
            'class_name' => '大陸三碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 72,
            'class_id' => 'TRCXM4',
            'class_name' => '大陸四碩士班',
            'default_color' => '灰',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 73,
            'class_id' => 'TRDXB4',
            'class_name' => '外交四',
            'default_color' => '白',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 74,
            'class_id' => 'TREAM3',
            'class_name' => '歐研碩歐盟三',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 74,
            'class_id' => 'TREAM4',
            'class_name' => '歐研碩歐盟四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 75,
            'class_id' => 'TREBM2',
            'class_name' => '歐研碩俄研二',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 75,
            'class_id' => 'TREBM3',
            'class_name' => '歐研碩俄研三',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 75,
            'class_id' => 'TREBM4',
            'class_name' => '歐研碩俄研四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 76,
            'class_id' => 'TREXD2',
            'class_name' => '歐研二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 76,
            'class_id' => 'TREXD3',
            'class_name' => '歐研三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 76,
            'class_id' => 'TREXD4',
            'class_name' => '歐研四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 76,
            'class_id' => 'TREXD5',
            'class_name' => '歐研五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 76,
            'class_id' => 'TREXD6',
            'class_name' => '歐研六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 76,
            'class_id' => 'TREXD7',
            'class_name' => '歐研七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 76,
            'class_id' => 'TREXM2',
            'class_name' => '歐研二碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 76,
            'class_id' => 'TREXM3',
            'class_name' => '歐研三碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 76,
            'class_id' => 'TREXM4',
            'class_name' => '歐研四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 77,
            'class_id' => 'TRFBM4',
            'class_name' => '美洲碩拉研四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 78,
            'class_id' => 'TRFCJ4',
            'class_name' => '亞太四數碩專',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 97,
            'class_id' => 'TRFXD5',
            'class_name' => '美洲五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 97,
            'class_id' => 'TRFXD7',
            'class_name' => '美洲七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 79,
            'class_id' => 'TRGXJ2',
            'class_name' => '日政經碩專二',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 79,
            'class_id' => 'TRGXJ3',
            'class_name' => '日政經碩專三',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 79,
            'class_id' => 'TRGXJ4',
            'class_name' => '日政經碩專四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 79,
            'class_id' => 'TRGXM2',
            'class_name' => '日本政經碩二',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 79,
            'class_id' => 'TRGXM3',
            'class_name' => '日本政經碩三',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 79,
            'class_id' => 'TRGXM4',
            'class_name' => '日本政經碩四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 80,
            'class_id' => 'TRHXM2',
            'class_name' => '臺灣亞太碩二',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 80,
            'class_id' => 'TRHXM4',
            'class_name' => '臺灣亞太碩四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 81,
            'class_id' => 'TRLAJ2',
            'class_name' => '拉美二數碩專',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 81,
            'class_id' => 'TRLAJ3',
            'class_name' => '拉美三數碩專',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 82,
            'class_id' => 'TRLXM2',
            'class_name' => '拉研二碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 82,
            'class_id' => 'TRLXM3',
            'class_name' => '拉研三碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 82,
            'class_id' => 'TRLXM4',
            'class_name' => '拉研四碩士班',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXD2',
            'class_name' => '戰略二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXD3',
            'class_name' => '戰略三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXD4',
            'class_name' => '戰略四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXD5',
            'class_name' => '戰略五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXD6',
            'class_name' => '戰略六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXD7',
            'class_name' => '戰略七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXJ2A',
            'class_name' => '戰略碩專二Ａ',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXJ2B',
            'class_name' => '戰略碩專二Ｂ',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXJ3',
            'class_name' => '戰略三碩專班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXJ4',
            'class_name' => '戰略四碩專班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXM2',
            'class_name' => '戰略二碩士班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXM3',
            'class_name' => '戰略三碩士班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 83,
            'class_id' => 'TRTXM4',
            'class_name' => '戰略四碩士班',
            'default_color' => '紫',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 84,
            'class_id' => 'TSAXB4',
            'class_name' => '尖端材料四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 85,
            'class_id' => 'TSCAM3',
            'class_name' => '化學碩化學三',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 85,
            'class_id' => 'TSCAM4',
            'class_name' => '化學碩化學四',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 86,
            'class_id' => 'TSCCB4',
            'class_name' => '化學系生化四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 87,
            'class_id' => 'TSCDB4',
            'class_name' => '化學系材化四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 88,
            'class_id' => 'TSCXD4',
            'class_name' => '化學四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 88,
            'class_id' => 'TSCXD5',
            'class_name' => '化學五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 88,
            'class_id' => 'TSCXD6',
            'class_name' => '化學六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 88,
            'class_id' => 'TSCXM2',
            'class_name' => '化學二碩士班',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 88,
            'class_id' => 'TSCXM3',
            'class_name' => '化學三碩士班',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 89,
            'class_id' => 'TSMAB4',
            'class_name' => '數學系數學四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 89,
            'class_id' => 'TSMAJ2',
            'class_name' => '數學二碩專班',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 89,
            'class_id' => 'TSMAJ3',
            'class_name' => '數學三碩專班',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 89,
            'class_id' => 'TSMAM2',
            'class_name' => '數學二碩士班',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 89,
            'class_id' => 'TSMAM4',
            'class_name' => '數學四碩士班',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 90,
            'class_id' => 'TSMCB4',
            'class_name' => '數學系資統四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 98,
            'class_id' => 'TSMXD2',
            'class_name' => '數學二博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 98,
            'class_id' => 'TSMXD3',
            'class_name' => '數學三博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 98,
            'class_id' => 'TSMXD4',
            'class_name' => '數學四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 98,
            'class_id' => 'TSMXD5',
            'class_name' => '數學五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 98,
            'class_id' => 'TSMXD7',
            'class_name' => '數學七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 91,
            'class_id' => 'TSPBB4',
            'class_name' => '物理系應物四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 92,
            'class_id' => 'TSPCB4',
            'class_name' => '物理系光電四',
            'default_color' => '藍',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 93,
            'class_id' => 'TSPXD4',
            'class_name' => '物理四博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 93,
            'class_id' => 'TSPXD5',
            'class_name' => '物理五博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 93,
            'class_id' => 'TSPXD6',
            'class_name' => '物理六博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 93,
            'class_id' => 'TSPXD7',
            'class_name' => '物理七博士班',
            'default_color' => null,
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 93,
            'class_id' => 'TSPXM2',
            'class_name' => '物理二碩士班',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 93,
            'class_id' => 'TSPXM3',
            'class_name' => '物理三碩士班',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 93,
            'class_id' => 'TSPXM4',
            'class_name' => '物理四碩士班',
            'default_color' => '黃',
        ]);

        DB::table('department_classes')->insert([
            'department_id' => 99,
            'class_id' => 'TSXAD2',
            'class_name' => '應科二博士班',
            'default_color' => null,
        ]);


    }
}
