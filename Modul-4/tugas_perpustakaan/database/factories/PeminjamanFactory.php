<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'anggota_id' => Anggota::inRandomOrder()->first()?->id ?? Anggota::factory(),
            'buku_id' => Buku::inRandomOrder()->first()?->id ?? Buku::factory(),
            'tanggal_pinjam' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'tanggal_kembali' => fake()->optional(0.7)->dateTimeBetween('now', '+2 weeks')?->format('Y-m-d'),
        ];
    }
}
