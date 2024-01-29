<?php

namespace Database\Seeders;

use App\Models\Jasa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jasa::factory()->create([
            'nama_jasa' => 'Potong Rambut Anak',
            'deskripsi' => 'Cukur rambut biasa khusus anak-anak',
            'harga' => 15000,
        ]);
        Jasa::factory()->create([
            'nama_jasa' => 'Potong Rambut Dewasa',
            'deskripsi' => 'Cukur rambut biasa khusus orang dewasa',
            'harga' => 20000,
        ]);
        Jasa::factory()->create([
            'nama_jasa' => 'Keriting Rambut',
            'deskripsi' => 'Keritingin Rambut',
            'harga' => 25000,
        ]);
        Jasa::factory()->create([
            'nama_jasa' => 'Make Up',
            'deskripsi' => 'Jasa Make Up Wajah',
            'harga' => 40000,
        ]);
        Jasa::factory()->create([
            'nama_jasa' => 'Pewarna (Colouring)',
            'deskripsi' => 'Jasa pewarnaan rambut',
            'harga' => 30000,
        ]);
    }
}
