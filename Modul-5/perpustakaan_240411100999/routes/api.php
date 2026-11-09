<?php

use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;
use App\Models\Kategori;
use Illuminate\Support\Facades\Route;

Route::apiResource('buku', BukuController::class)->only(['index', 'show']);

Route::middleware(['web', 'auth', 'permission:kelola data buku'])->group(function () {
    Route::apiResource('buku', BukuController::class)->only(['store', 'update', 'destroy']);
});

Route::get('rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori']);
Route::get('rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);

Route::get('kategori', function () {
    return response()->json([
        'data' => Kategori::select('id', 'nama')->orderBy('nama')->get(),
    ]);
});