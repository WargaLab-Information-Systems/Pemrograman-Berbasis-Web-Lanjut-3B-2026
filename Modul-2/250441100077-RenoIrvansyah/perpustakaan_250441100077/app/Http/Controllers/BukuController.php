<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $buku = [
        [
            'id' => 1,
            'judul' => 'Jujutsu Kaisen Vol. 1',
            'penulis' => 'Gege Akutami',
            'tahun' => 2018,
            'kategori' => 'Manga',
            'poster' => 'Jujutsu_Kaisen_Vol1.jpeg',
        ],
        [
            'id' => 2,
            'judul' => 'Bleach Vol. 1',
            'penulis' => 'Tite Kubo',
            'tahun' => 2018,
            'kategori' => 'Manga',
            'poster' => 'Bleach_Vol1.jpeg',
        ],
        [
            'id' => 3,
            'judul' => 'Koala Kumal',
            'penulis' => 'Raditya Dika',
            'tahun' => 2015,
            'kategori' => 'Novel',
            'poster' => 'Koala-Kumal-radityadika.png',
        ],
        [
            'id' => 4,
            'judul' => 'Wangsit Om Jero 2025: Penalaran Umum',
            'penulis' => 'Om Jero',
            'tahun' => 2025,
            'kategori' => 'Akademik',
            'poster' => 'WangsitOmJero2025-Penalaran Umum.png',
        ],
        [
            'id' => 5,
            'judul' => 'Harry Potter and the Half-Blood Prince',
            'penulis' => 'J.K. Rowling',
            'tahun' => 2009,
            'kategori' => 'Fiksi',
            'poster' => 'HarryPotter-HalfBloodPrince.png',
        ],
    ];

    public function index()
    {
        $buku = $this->buku;

        return view('buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $buku = collect($this->buku)->firstWhere('id', $id);

        return view('buku.detail', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
