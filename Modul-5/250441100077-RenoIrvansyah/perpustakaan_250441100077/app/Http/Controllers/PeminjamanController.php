<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->get();

        $anggotas = Anggota::all();

        // Hanya menampilkan buku yang tersedia
        $bukus = Buku::where('status', 'tersedia')->get();

        return view('peminjaman.index', compact(
            'peminjamans',
            'anggotas',
            'bukus'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {

            $buku = Buku::whereKey($request->buku_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($buku->status !== 'tersedia') {
                throw ValidationException::withMessages([
                    'buku_id' => 'Buku sedang dipinjam dan tidak tersedia.',
                ]);
            }

            Peminjaman::create([
                'anggota_id' => $request->anggota_id,
                'buku_id' => $request->buku_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
            ]);

            $buku->update([
                'status' => 'dipinjam',
            ]);
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function riwayat()
    {
        $anggota = auth()->user()->anggota;

        if (!$anggota) {
            abort(403, 'Data anggota belum terhubung dengan akun Anda.');
        }

        $peminjamans = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->get();

        return view('peminjaman.riwayat', compact('peminjamans'));
    }

    public function pengembalian()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->whereNull('tanggal_kembali')
            ->latest()
            ->get();

        return view('pengembalian.index', compact('peminjamans'));
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        if ($peminjaman->tanggal_kembali !== null) {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        DB::transaction(function () use ($peminjaman) {
            $peminjaman->update([
                'tanggal_kembali' => now()->toDateString(),
            ]);

            $peminjaman->buku->update([
                'status' => 'tersedia',
            ]);
        });

        return redirect()->route('pengembalian.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}
