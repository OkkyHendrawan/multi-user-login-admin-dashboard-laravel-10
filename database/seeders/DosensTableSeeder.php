<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DosensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('dosens')->insert([
        //     'dosen_npp' => '12345',
        //     'dosen_nama' => 'Dosen',
        //     'email' => 'dosen@gmail.com',
        //     'password' => Hash::make('123'),
        //     'dosen_alamat' => 'Jalan Dosen',
        //     'dosen_nomor_hp' => '081234567890',
        //     'dosen_foto' => 'dosen.jpg',
        //     'dosen_prodi_id' => 1,
        //     'dosen_status' => 1,
        // ]);
    }
}
