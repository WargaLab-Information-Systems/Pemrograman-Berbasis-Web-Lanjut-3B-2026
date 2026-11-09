
<?php

use App\Http\Controllers\Api\BukuController;
use Illuminate\Support\Facades\Route;
use App\Models\Kategori;

// API menggunakan session login Laravel
Route::middleware(['web', 'auth'])->group(function () {

    // Kategori untuk form pengelolaan buku
    Route::get('/kategori', function () {
        return response()->json(
            Kategori::select('id', 'nama')->get()
        );
    })->middleware('permission:kelola data buku');

    // Melihat daftar dan detail buku: semua role
    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat daftar buku');

    Route::get('/buku/{buku}', [BukuController::class, 'show'])
        ->middleware('permission:lihat daftar buku');

    // Mengelola buku: Admin dan Petugas
    Route::post('/buku', [BukuController::class, 'store'])
        ->middleware('permission:kelola data buku');

    Route::put('/buku/{buku}', [BukuController::class, 'update'])
        ->middleware('permission:kelola data buku');

    Route::patch('/buku/{buku}', [BukuController::class, 'update'])
        ->middleware('permission:kelola data buku');

    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
        ->middleware('permission:kelola data buku');

    // Laporan perpustakaan: Admin dan Petugas
    Route::get('/rekap/buku-per-kategori', [BukuController::class, 'rekapBukuPerKategori'])
        ->middleware('permission:lihat laporan perpustakaan');

    Route::get('/rekap/peminjaman-per-buku', [BukuController::class, 'rekapPeminjamanPerBuku'])
        ->middleware('permission:lihat laporan perpustakaan');
});
