<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{
    // Data buku sementara
    private function daftarBuku()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun' => 2005,
                'kategori' => 'Novel',
                'deskripsi' => 'Kisah perjuangan anak-anak Belitung dalam meraih pendidikan dan cita-cita.',
                'gambar' => 'images/Laskar Pelangi.jpg',
            ],
            [
                'id' => 2,
                'judul' => 'Bumi',
                'penulis' => 'Tere Liye',
                'tahun' => 2014,
                'kategori' => 'Fantasi',
                'deskripsi' => 'Petualangan Raib, Seli, dan Ali dalam dunia paralel yang penuh misteri.',
            ],
            [
                'id' => 3,
                'judul' => 'Negeri 5 Menara',
                'penulis' => 'Ahmad Fuadi',
                'tahun' => 2009,
                'kategori' => 'Novel',
                'deskripsi' => 'Perjalanan enam santri yang mengejar impian dengan semangat dan keyakinan.',
            ],
            [
                'id' => 4,
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'tahun' => 2018,
                'kategori' => 'Pengembangan Diri',
                'deskripsi' => 'Pengenalan filsafat Stoisisme untuk membantu menghadapi kehidupan sehari-hari.',
                'gambar' => 'images/Filosofi Teras.jpg',
            ],
            [
                'id' => 5,
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'tahun' => 1980,
                'kategori' => 'Sejarah',
                'deskripsi' => 'Kisah Minke dalam menghadapi kehidupan sosial pada masa kolonial Hindia Belanda.',
                'gambar' => 'images/Bumi Manusia.jpg',
            ],
        ];
    }

    // Halaman Daftar Buku
    public function index()
    {
        $buku = $this->daftarBuku();

        return view('buku.index', compact('buku'));
    }

    // Halaman Detail Buku
    public function detail($id)
    {
        $buku = collect($this->daftarBuku())
            ->firstWhere('id', (int) $id);

        return view('buku.detail', compact('buku'));
    }
}
