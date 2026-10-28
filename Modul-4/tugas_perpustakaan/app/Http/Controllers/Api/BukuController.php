<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Http\Resources\BukuResource;
use Illuminate\Http\Request;


class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')->latest()->get();
        return BukuResource::collection($bukus);
    }

    public function store(Request $request)
    {
        // Validasi otomatis mengembalikan HTTP 422 JSON jika gagal (Soal 5)
        $validated = $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric|digits:4',
        ]);

        $buku = Buku::create($validated);
        return new BukuResource($buku);
    }

    public function show($id)
    {
        // Mengembalikan HTTP 404 jika ID tidak ditemukan (Soal 5)
        $buku = Buku::with('kategori')->findOrFail($id);
        return new BukuResource($buku);
    }

    public function shows($id)
    {
        // Mengembalikan file view show.blade.php dengan membawa $id
        return view('buku.show', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric|digits:4',
        ]);

        $buku->update($validated);
        return new BukuResource($buku);
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }
}