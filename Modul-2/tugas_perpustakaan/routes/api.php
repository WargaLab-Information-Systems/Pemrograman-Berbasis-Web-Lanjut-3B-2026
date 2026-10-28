<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;

Route::get('/rekap/buku-per-kategori', [BukuController::class, 'rekapBukuPerKategori']);
Route::get('/rekap/peminjaman-per-buku', [BukuController::class, 'rekapPeminjamanPerBuku']);

Route::apiResource('buku', BukuController::class);
