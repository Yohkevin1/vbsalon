<?php

namespace Database\Seeders;

use App\Models\Detail_Jasa;
use Carbon\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Detail_JasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Detail_Jasa::factory()->create([
            'id_jasa' => '3',
            'jumlah' => '1',
            'subtotal' => '25000',
            'no_penjualan' => 'PJL25102300001',
        ]);
        Detail_Jasa::factory()->create([
            'id_jasa' => '2',
            'jumlah' => '1',
            'subtotal' => '20000',
            'no_penjualan' => 'PJL25102300002',
        ]);
        Detail_Jasa::factory()->create([
            'id_jasa' => '4',
            'jumlah' => '1',
            'subtotal' => '40000',
            'no_penjualan' => 'PJL25102300003',
        ]);
        Detail_Jasa::factory()->create([
            'id_jasa' => '4',
            'jumlah' => '1',
            'subtotal' => '40000',
            'no_penjualan' => 'PJL25102300004',
        ]);
        Detail_Jasa::factory()->create([
            'id_jasa' => '5',
            'jumlah' => '1',
            'subtotal' => '30000',
            'no_penjualan' => 'PJL25102300005',
        ]);
    }
}
