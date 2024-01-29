<?php

namespace Database\Seeders;

use App\Http\Controllers\C_Supplier;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::factory()->create([
            'kode_supplier' => "SPR25102300001",
            'nama' => 'L Oréal',
            'email' => 'LOréal@gmail.com',
            'alamat' => 'DBS Bank Tower, 29th floor, Ciputra World 1, Kuningan, Jl. Prof. DR. Satrio No.Kav 3-5, RT.18/RW.4, Kuningan, Karet Kuningan, Setiabudi, South Jakarta City, Jakarta 12940',
            'telp' => '089944663722',
        ]);
        Supplier::factory()->create([
            'kode_supplier' => "SPR25102300002",
            'nama' => 'Skintific Indonesia',
            'email' => 'Skintific@gmail.com',
            'alamat' => ' Menara Prima, Jl. DR. Ide Anak Agung Gde Agung No.5, RT.5/RW.2, Kuningan, Kuningan Tim., Kecamatan Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12950',
            'telp' => '085691691608',
        ]);
        Supplier::factory()->create([
            'kode_supplier' => "SPR25102300003",
            'nama' => 'PT. DEF',
            'email' => 'DEF@gmail.com',
            'alamat' => 'Cirebon',
            'telp' => '084455336725',
        ]);
        Supplier::factory()->create([
            'kode_supplier' => "SPR25102300004",
            'nama' => 'PT. GHI',
            'email' => 'GHI@gmail.com',
            'alamat' => 'Solo',
            'telp' => '084453662734',
        ]);
        Supplier::factory()->create([
            'kode_supplier' => "SPR25102300005",
            'nama' => 'PT. JKL',
            'email' => 'JKL@gmail.com',
            'alamat' => 'Semarang',
            'telp' => '085644132546',
        ]);
    }
}
