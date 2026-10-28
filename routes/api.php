<?php

use App\Http\Controllers\Api\BukuController;
use Illuminate\Support\Facades\Route;
use App\Models\Kategori;

Route::get('/kategori', function () {
    return response()->json(
        Kategori::select('id', 'nama')->get()
    );
});

Route::apiResource('buku', BukuController::class);

Route::get('/rekap/buku-per-kategori', [BukuController::class, 'rekapBukuPerKategori']);
Route::get('/rekap/peminjaman-per-buku', [BukuController::class, 'rekapPeminjamanPerBuku']);