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
        DB::table('users')->insert([
            'name' => '管理員',
            'username' => 'admin',          // 預設帳號
            'email' => 'aaa@aaa.aaa',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => User::ADMIN,
            'stamp' => ''
        ]);
        DB::table('users')->insert([
            'name' => '學生一',
            'username' => '40641000',          // 預設帳號
            'email' => '40641000@gms.tku.edu.tw',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => User::STUDENT,
            'school_year_id' => 1,
            'department_id' => 25,
            'grade' => '四',
            'class' => '測試班'
        ]);
        DB::table('users')->insert([
            'name' => '學生二',
            'username' => '40641001',          // 預設帳號
            'email' => '40641001@gms.tku.edu.tw',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => User::STUDENT,
            'school_year_id' => 1,
            'department_id' => 25,
            'grade' => '四',
            'class' => 'A'
        ]);
    }
}
