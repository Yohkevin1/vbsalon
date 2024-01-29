<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PegawaiSeeder::class);
        $this->call(JasaSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(ProdukSeeder::class);
        $this->call(PembelianSeeder::class);
        $this->call(PenjualanSeeder::class);
        $this->call(Detail_ProdukSeeder::class);
        $this->call(Detail_JasaSeeder::class);
    }
}
