<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => 'Admin HealthMo',
            'email' => 'healthmonitoring12@gmail.com',
            'no_hp' => '087733798090',
            'level' => 'Admin',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 1,
            'password' => bcrypt('admin'),


        ]);
        
        DB::table('ip_esps')->insert([
            'ip_esp' => 'http://192.168.244.232/',
        ]);
    }
}
