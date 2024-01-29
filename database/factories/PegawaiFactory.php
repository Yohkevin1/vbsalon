<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $adminUser = User::where('username', 'Owner')->first();

        return [
            'no_pegawai' => 'PGW230716000001',
            'nama' => 'Admin',
            'email' => 'Admin@gmail.com',
            'tgl_lahir' => '1995-07-10',
            'alamat' => 'Jl. Tambak Boyo',
            'no_hp' => '087856136034',
            'id_user' => $adminUser->id_user,
        ];
    }
}
