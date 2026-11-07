<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\JsonResponse;

class RekapController extends Controller
{
    public function bukuPerKategori(): JsonResponse
    {
        $rekap = Kategori::withCount('bukus')->get();

        return response()->json($rekap, 200);
    }

    public function peminjamanPerBuku(): JsonResponse
    {
        $rekap = Buku::withCount('peminjamans')->get();

        return response()->json($rekap, 200);
    }
}
