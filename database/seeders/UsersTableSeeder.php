<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Tambahkan data pengguna
        // DB::table('users')->insert([
        //     'name' => 'Admin',
        //     'email' => 'admin29@gmail.com',
        //     'password' => Hash::make('123'),
        //     'role' => 'admin',
        // ]);
    }
}
