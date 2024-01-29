<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Pegawai::factory()->create([
            'no_pegawai' => 'PGW25102300001',
            'nama' => 'Owner',
            'email' => 'Owner@gmail.com',
            'tgl_lahir' => '1999-07-10',
            'alamat' => 'Jl. Tambak Boyo',
            'no_hp' => '087856136034',
            'id_user' => '1'
        ]);

        \App\Models\Pegawai::factory()->create([
            'no_pegawai' => 'PGW25102300002',
            'nama' => 'Admin',
            'email' => 'Admin@gmail.com',
            'tgl_lahir' => '1999-07-10',
            'alamat' => 'Jl. Tambak Buaya',
            'no_hp' => '08976564332',
            'id_user' => '2'
        ]);

        \App\Models\Pegawai::factory()->create([
            'no_pegawai' => 'PGW25102300003',
            'nama' => 'Pegawai',
            'email' => 'Pegawai@gmail.com',
            'tgl_lahir' => '1999-07-10',
            'alamat' => 'Jl. Tambak Tambakan',
            'no_hp' => '098234724783',
            'id_user' => '3'
        ]);

        \App\Models\Pegawai::factory()->create([
            'no_pegawai' => 'PGW25102300004',
            'nama' => 'Muhammad Zam Zam',
            'email' => 'zamzam@gmail.com',
            'tgl_lahir' => '2003-07-10',
            'alamat' => 'Jl. Kenangan',
            'no_hp' => '0899446633722',
            'id_user' => '4'
        ]);

        \App\Models\Pegawai::factory()->create([
            'no_pegawai' => 'PGW25102300005',
            'nama' => 'Yohanes Kevin',
            'email' => 'yohvin@gmail.com',
            'tgl_lahir' => '2003-05-01',
            'alamat' => 'Jl. Adhi Karya',
            'no_hp' => '089944773644',
            'id_user' => '5'
        ]);
    }
}
