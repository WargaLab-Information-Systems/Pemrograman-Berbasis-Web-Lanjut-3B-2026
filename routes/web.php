
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

Route::view('/', 'home')->name('home');

// Halaman daftar buku
Route::get('/buku', [BukuController::class, 'index'])
    ->name('web.buku.index');

// Halaman detail buku
Route::get('/buku/{id}', [BukuController::class, 'show'])
    ->name('web.buku.show');

