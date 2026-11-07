<?php

// use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;

// Route::apiResource('buku', BukuController::class);
// Route::name('api.')->group(function () {
//     Route::apiResource('buku', BukuController::class);
// });

Route::middleware('auth:sanctum')->group(function () {

    // API Buku
    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat daftar buku');

    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->middleware('permission:lihat daftar buku');

    Route::post('/buku', [BukuController::class, 'store'])
        ->middleware('permission:kelola data buku');

    Route::put('/buku/{id}', [BukuController::class, 'update'])
        ->middleware('permission:kelola data buku');

    Route::patch('/buku/{id}', [BukuController::class, 'update'])
        ->middleware('permission:kelola data buku');

    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])
        ->middleware('permission:kelola data buku');

    // API Rekap
    Route::get('/rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori'])
        ->middleware('permission:lihat laporan perpustakaan');

    Route::get('/rekap/pemminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku'])
        ->middleware('permission:lihat laporan perpustakaan');
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
