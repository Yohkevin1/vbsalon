<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::factory()->create([
            'nama_role' => 'owner'
        ]);
        \App\Models\Role::factory()->create([
            'nama_role' => 'admin'
        ]);
        \App\Models\Role::factory()->create([
            'nama_role' => 'pegawai'
        ]);
    }
}
