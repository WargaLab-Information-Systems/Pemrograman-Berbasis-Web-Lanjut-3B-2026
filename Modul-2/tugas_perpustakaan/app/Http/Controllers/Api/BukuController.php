<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->withCount('peminjaman');

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        $bukus = $query->latest()->paginate(10)->withQueryString();

        return response()->json($bukus, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        $buku = Buku::create($request->validated());

        return response()->json($buku, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjaman'])->find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        return response()->json($buku, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $buku->update($request->validated());

        return response()->json($buku, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }

    /**
     * Rekap jumlah buku per kategori
     */
    public function rekapBukuPerKategori()
    {
        $rekap = Buku::select('kategori_id', DB::raw('count(*) as jumlah_buku'))
            ->with('kategori')
            ->groupBy('kategori_id')
            ->get();

        return response()->json($rekap, 200);
    }

    /**
     * Rekap total peminjaman per buku
     */
    public function rekapPeminjamanPerBuku()
    {
        $rekap = Buku::withCount('peminjaman')->get();

        return response()->json($rekap, 200);
    }
}