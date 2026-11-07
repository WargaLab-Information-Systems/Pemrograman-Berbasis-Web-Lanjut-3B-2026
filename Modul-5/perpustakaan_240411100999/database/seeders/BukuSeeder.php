<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // Ganti dengan data dari array lama di controller
        $data = [
            ['judul' => 'Laskar Pelangi',          'penulis' => 'Andrea Hirata',   'tahun_terbit' => 2005],
            ['judul' => 'Bumi Manusia',            'penulis' => 'Pramoedya A. Toer', 'tahun_terbit' => 1980],
            ['judul' => 'Negeri 5 Menara',         'penulis' => 'Ahmad Fuadi',     'tahun_terbit' => 2009],
            ['judul' => 'Pulang',                  'penulis' => 'Tere Liye',       'tahun_terbit' => 2015],
            ['judul' => 'Filosofi Teras',          'penulis' => 'Henry Manampiring', 'tahun_terbit' => 2018],
        ];

        foreach ($data as $item) {
            Buku::factory()->create($item); // kategori_id tetap diisi Factory
        }
    }
}