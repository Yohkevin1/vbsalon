<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //produk Creme & jasa keriting rambut
        Penjualan::factory()->create([
            'no_penjualan' => 'PJL25102300001',
            'telp_pelanggan' => 'NULL',
            'total_harga' => 158000,
            'bayar' => 200000,
            'no_pegawai' => 'PGW25102300004'
        ]);
        // jasa potong rambut & produk pewarna biru
        Penjualan::factory()->create([
            'no_penjualan' => 'PJL25102300002',
            'telp_pelanggan' => 'NULL',
            'total_harga' => 120000,
            'bayar' => 150000,
            'no_pegawai' => 'PGW25102300005'
        ]);
        //jasa makeup & produk Gold hair
        Penjualan::factory()->create([
            'no_penjualan' => 'PJL25102300003',
            'telp_pelanggan' => '089936473911',
            'total_harga' => 87500,
            'bayar' => 100000,
            'no_pegawai' => 'PGW25102300004'
        ]);
        //jasa makeup & produk flash cat
        Penjualan::factory()->create([
            'no_penjualan' => 'PJL25102300004',
            'telp_pelanggan' => '089936433935',
            'total_harga' => 169000,
            'bayar' => 200000,
            'no_pegawai' => 'PGW25102300005'
        ]);
        //jasa pewarnaan ramut & produk creme
        Penjualan::factory()->create([
            'no_penjualan' => 'PJL25102300005',
            'telp_pelanggan' => 'NULL',
            'total_harga' => 163000,
            'bayar' => 200000,
            'no_pegawai' => 'PGW25102300001'
        ]);
    }
}
