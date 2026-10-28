<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Buku;
use App\Models\Anggota;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'anggota_id' => Anggota::inRandomOrder()->value('id'),
            'buku_id' => Buku::inRandomOrder()->value('id'),
            'tanggal_pinjam' => fake()->date(),
            'tanggal_kembali' => fake()->boolean(70) ? fake()->date() : null,
        ];
    }
}
