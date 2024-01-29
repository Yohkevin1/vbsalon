<?php

namespace Database\Seeders;

use App\Models\Detail_Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Detail_ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Detail_Produk::factory()->create([
            'kode_produk' => 'PRD25102300004',
            'jumlah' => '1',
            'subtotal' => '133000',
            'no_penjualan' => 'PJL25102300001',
        ]);
        Detail_Produk::factory()->create([
            'kode_produk' => 'PRD25102300001',
            'jumlah' => '1',
            'subtotal' => '100000',
            'no_penjualan' => 'PJL25102300002',
        ]);
        Detail_Produk::factory()->create([
            'kode_produk' => 'PRD25102300002',
            'jumlah' => '1',
            'subtotal' => '47500',
            'no_penjualan' => 'PJL25102300003',
        ]);
        Detail_Produk::factory()->create([
            'kode_produk' => 'PRD25102300005',
            'jumlah' => '1',
            'subtotal' => '129000',
            'no_penjualan' => 'PJL25102300004',
        ]);
        Detail_Produk::factory()->create([
            'kode_produk' => 'PRD25102300004',
            'jumlah' => '1',
            'subtotal' => '133000',
            'no_penjualan' => 'PJL25102300005',
        ]);
    }
}
