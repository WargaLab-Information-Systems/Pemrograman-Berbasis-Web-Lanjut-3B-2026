<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class BukuController extends Controller
{
    private function dataBuku()
    {
        return Buku::with('kategori')->get()->map(function ($buku) {
            return [
                'id' => $buku->id,
                'judul' => $buku->judul,
                'penulis' => $buku->penulis,
                'tahun' => $buku->tahun_terbit,
                'kategori' => $buku->kategori->nama,
            ];
        })->toArray();
    }

    public function index()
    {
        $buku = $this->dataBuku();

        return view('buku.index', compact('buku'));
    }

    public function show($id)
    {
        $buku = collect($this->dataBuku())
            ->firstWhere('id', (int) $id);

        return view('buku.show', compact('buku'));
    }
}



