<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PeminjamanController extends Controller
{
    // Menampilkan semua peminjaman untuk Admin dan Petugas
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    // Menyimpan data peminjaman
    public function store(Request $request)
    {
        $data = $request->validate([
            'anggota_id' => ['required', 'exists:anggotas,id'],
            'buku_id' => ['required', 'exists:bukus,id'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_kembali' => [
                'required',
                'date',
                'after_or_equal:tanggal_pinjam'
            ],
        ]);

        Peminjaman::create($data);

        return redirect()
            ->back()
            ->with('success', 'Peminjaman berhasil dicatat.');
    }

    // Memproses pengembalian buku
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->tanggal_dikembalikan) {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $peminjaman->update([
            'tanggal_dikembalikan' => now()->toDateString(),
        ]);

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    // Riwayat peminjaman milik siswa yang sedang login
    public function riwayatSaya()
    {
        $anggota = auth()->user()->anggota;

        if (!$anggota) {
            abort(404, 'Data anggota belum terhubung dengan akun ini.');
        }

        $peminjaman = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->get();

        return view('peminjaman.riwayat', compact('peminjaman'));
    }
}
