<?php

namespace Database\Seeders;

use App\Models\Pembelian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pembelian::factory()->create([
            'no_pembelian' => 'PBL25102300001',
            'no_pegawai' => 'PGW25102300001',
            'total_harga' => 120000,
            'keterangan' => 'Pembayaran Listrik Bulan Oktober'
        ]);
        Pembelian::factory()->create([
            'no_pembelian' => 'PBL25102300002',
            'no_pegawai' => 'PGW25102300001',
            'total_harga' => 350000,
            'keterangan' => 'Pembelian HairDyer'
        ]);
        Pembelian::factory()->create([
            'no_pembelian' => 'PBL25102300003',
            'no_pegawai' => 'PGW25102300001',
            'total_harga' => 900000,
            'keterangan' => 'Pembayaran Gold Hair Serum',
            'kode_produk' => 'PRD25102300002'
        ]);
        Pembelian::factory()->create([
            'no_pembelian' => 'PBL25102300004',
            'no_pegawai' => 'PGW25102300001',
            'total_harga' => 300000,
            'keterangan' => 'Pembelian Alat Cukur Rambut',
        ]);
        Pembelian::factory()->create([
            'no_pembelian' => 'PBL25102300005',
            'no_pegawai' => 'PGW25102300001',
            'total_harga' => 120000,
            'keterangan' => 'Pembelian sisir dan peralatan lain',
        ]);
    }
}
