<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    private function dataPeminjaman()
    {
        return DB::table('peminjamans')
            ->join('bukus', 'bukus.id', '=', 'peminjamans.buku_id')
            ->select('peminjamans.*', 'bukus.judul')
            ->orderByDesc('peminjamans.id')
            ->get();
    }

    public function index()
    {
        return view('peminjaman.index', [
            'judul' => 'Data Peminjaman',
            'data'  => $this->dataPeminjaman(),
        ]);
    }

    public function pengembalian()
    {
        return view('peminjaman.index', [
            'judul' => 'Data Pengembalian',
            'data'  => $this->dataPeminjaman(),
        ]);
    }

    // riwayat milik akun yang sedang login
    public function riwayatSaya(Request $request)
    {
        return $this->tampilRiwayat($request->user()->anggota);
    }

    // riwayat anggota tertentu: hanya pemilik, atau admin/petugas yang mengelola peminjaman
    public function riwayat(Request $request, Anggota $anggota)
    {
        $user = $request->user();

        abort_unless(
            $anggota->user_id === $user->id || $user->can('kelola peminjaman'),
            403
        );

        return $this->tampilRiwayat($anggota);
    }

    private function tampilRiwayat(?Anggota $anggota)
    {
        $data = collect();

        if ($anggota) {
            $data = DB::table('peminjamans')
                ->join('bukus', 'bukus.id', '=', 'peminjamans.buku_id')
                ->where('peminjamans.anggota_id', $anggota->id)
                ->select('peminjamans.*', 'bukus.judul')
                ->orderByDesc('peminjamans.id')
                ->get();
        }

        return view('riwayat.index', compact('anggota', 'data'));
    }
}