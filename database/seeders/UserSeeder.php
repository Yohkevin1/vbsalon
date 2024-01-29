<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'username' => 'Owner',
            'password' => Hash::make('123456789'),
            'id_role' => '1'
        ]);
        \App\Models\User::factory()->create([
            'username' => 'Admin',
            'password' => Hash::make('123456789'),
            'id_role' => '2'
        ]);

        \App\Models\User::factory()->create([
            'username' => 'Pegawai',
            'password' => Hash::make('123456789'),
            'id_role' => '3'
        ]);

        \App\Models\User::factory()->create([
            'username' => 'ZamZam',
            'password' => Hash::make('123456789'),
            'id_role' => '3'
        ]);

        \App\Models\User::factory()->create([
            'username' => 'Yohkevin',
            'password' => Hash::make('123456789'),
            'id_role' => '3'
        ]);
    }
}
