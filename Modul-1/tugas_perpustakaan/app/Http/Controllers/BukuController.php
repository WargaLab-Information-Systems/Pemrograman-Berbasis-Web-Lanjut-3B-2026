<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    private $buku = [
        [
            'id' => 1, 
            'judul' => 'Ayat-ayat kiri', 
            'penulis' => 'Karl Marx', 
            'tahun_terbit' => 2019, 
            'kategori' => 'Politik',
            'gambar' => 'buku1.jpg'
        ],
        [
            'id' => 2, 
            'judul' => 'Bocoran Pertanyaan Alam Kubur Plus Kunci Jawaban ditulis', 
            'penulis' => ' M. Syafii Masykur', 
            'tahun_terbit' => 2015, 
            'kategori' => 'Spiritual',
            'gambar' => 'buku2.jpg'
        ],
        [
            'id' => 3, 
            'judul' => 'Debat Sengit Malaikat Izrail vs Calon Jenazah', 
            'penulis' => '-', 
            'tahun_terbit' => 2018, 
            'kategori' => 'Fiksi',
            'gambar' => 'buku3.jpg'
        ],
        [
            'id' => 4, 
            'judul' => 'Mudik bersama Yesus', 
            'penulis' => 'Rd. Tarcisius Puryatno', 
            'tahun_terbit' => 2014, 
            'kategori' => 'Spiritualitas',
            'gambar' => 'buku4.jpg'
        ],
        [
            'id' => 5, 
            'judul' => 'Masa Lalu yang Terkubur', 
            'penulis' => 'Tony Wong', 
            'tahun_terbit' => 1990, 
            'kategori' => 'Komik',
            'gambar' => 'buku5.jpg'
        ],
        [
            'id' => 6, 
            'judul' => 'Gibran', 
            'penulis' => 'Gibran', 
            'tahun_terbit' => 2025, 
            'kategori' => 'Komedi',
            'gambar' => 'buku6.jpg'
        ]
    ];
    public function index()
    {
        return view('buku.index', ['buku' => $this->buku]);
    }

    public function show($id)
    {
        $detailBuku = collect($this->buku)->firstWhere('id', $id);
        return view('buku.show', ['buku' => $detailBuku]);
    }
}
