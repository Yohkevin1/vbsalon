<?php

namespace Database\Seeders;

use App\Http\Controllers\C_Produk;
use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::factory()->create([
            'kode_produk' => "PRD25102300001",
            'merek' => 'Pewarna Rambut Biru',
            'deskripsi' => 'Pewarna Rambut Biru',
            'jumlah' => 20,
            'harga' => 100000,
            'status' => 'ready',
            'kode_supplier' => 'SPR25102300003'
        ]);
        Produk::factory()->create([
            'kode_produk' => "PRD25102300002",
            'merek' => 'Gold Hair Serum',
            'deskripsi' => 'Serum perawatan rambut berkilau dari LOreal Paris. Serum ini mengandung ekstrak 6 bunga langka untuk menutrisi & melindungi rambut, sehingga rambut jadi halus, lembut, dan berkilau.',
            'jumlah' => 20,
            'harga' => 47500,
            'status' => 'ready',
            'kode_supplier' => 'SPR25102300001'
        ]);
        Produk::factory()->create([
            'kode_produk' => "PRD25102300003",
            'merek' => 'FLASH SKINTIFIC 5% Panthenol Acne Calming Water Gel 45g',
            'deskripsi' => 'FLASH SKINTIFIC 5% Panthenol Acne Calming Water Gel 45g',
            'jumlah' => 15,
            'harga' => 109000,
            'status' => 'ready',
            'kode_supplier' => 'SPR25102300002'
        ]);
        Produk::factory()->create([
            'kode_produk' => "PRD25102300004",
            'merek' => 'Crème Excellence Crème #5 Natural Light Brown',
            'deskripsi' => 'Cat rambut cokelat terang dari L`Orèal. Dilengkapi dengan Triple Care Formula untuk melindungi rambutmu sebelum, selama, dan sesudah proses pewarnaan.',
            'jumlah' => 15,
            'harga' => 133000,
            'status' => 'ready',
            'kode_supplier' => 'SPR25102300004'
        ]);
        Produk::factory()->create([
            'kode_produk' => "PRD25102300005",
            'merek' => 'Flash Cat Flash Cat Eyeliner',
            'deskripsi' => 'Super Liner Flash Cat Eyeliner adalah inovasi eyeliner waterproof untuk membentuk wing liner yang mudah dan sempurna',
            'jumlah' => 15,
            'harga' => 129000,
            'status' => 'ready',
            'kode_supplier' => 'SPR25102300005'
        ]);
    }
}
