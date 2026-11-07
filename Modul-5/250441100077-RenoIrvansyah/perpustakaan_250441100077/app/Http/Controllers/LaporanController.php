<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        // Statistik perpustakaan
        $totalBuku = Buku::count();

        $totalAnggota = Anggota::count();

        $totalPeminjaman = Peminjaman::count();

        $sedangDipinjam = Peminjaman::whereNull('tanggal_kembali')
            ->count();

        $sudahDikembalikan = Peminjaman::whereNotNull('tanggal_kembali')
            ->count();

        // Riwayat transaksi
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->paginate(10);

        return view('laporan.index', compact(
            'totalBuku',
            'totalAnggota',
            'totalPeminjaman',
            'sedangDipinjam',
            'sudahDikembalikan',
            'peminjamans'
        ));
    }
}
