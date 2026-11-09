<?php

use App\Http\Controllers\AdminPenggunaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ===== Publik (Modul 1) - Kembali ke halaman Selamat Datang =====
Route::get('/', fn () => view('home'))->name('home');

// ===== Dashboard: diarahkan sesuai role =====
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->can('akses dashboard admin')) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->can('akses dashboard petugas')) {
        return redirect()->route('petugas.dashboard');
    }

    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth', 'permission:akses dashboard admin'])
    ->get('/admin/dashboard', fn () => view('admin.dashboard'))
    ->name('admin.dashboard');

Route::middleware(['auth', 'permission:akses dashboard petugas'])
    ->get('/petugas/dashboard', fn () => view('petugas.dashboard'))
    ->name('petugas.dashboard');

// ===== Buku: memakai BukuController yang sudah ada =====
Route::middleware(['auth', 'permission:lihat daftar buku'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->whereNumber('id')->name('buku.show');
});

Route::middleware(['auth', 'permission:kelola data buku'])
    ->get('/kelola/buku', [BukuController::class, 'index'])
    ->name('buku.kelola');

// ===== Pengguna dan role (khusus admin) =====
Route::middleware(['auth', 'permission:kelola data pengguna'])->group(function () {
    Route::get('/admin/pengguna', [AdminPenggunaController::class, 'index'])
        ->name('admin.pengguna.index');
    Route::delete('/admin/pengguna/{user}', [AdminPenggunaController::class, 'destroy'])
        ->name('admin.pengguna.destroy');
});

Route::middleware(['auth', 'permission:kelola role pengguna'])
    ->patch('/admin/pengguna/{user}/role', [AdminPenggunaController::class, 'updateRole'])
    ->name('admin.pengguna.role');

// ===== Operasional (admin dan petugas) =====
Route::middleware(['auth', 'permission:kelola peminjaman'])
    ->get('/peminjaman', [PeminjamanController::class, 'index'])
    ->name('peminjaman.index');

Route::middleware(['auth', 'permission:kelola pengembalian'])
    ->get('/pengembalian', [PeminjamanController::class, 'pengembalian'])
    ->name('pengembalian.index');

Route::middleware(['auth', 'permission:lihat laporan perpustakaan'])
    ->get('/laporan', fn () => view('laporan.index'))
    ->name('laporan.index');

Route::middleware(['auth', 'permission:lihat riwayat peminjaman sendiri'])->group(function () {
    Route::get('/riwayat-saya', [PeminjamanController::class, 'riwayatSaya'])->name('riwayat.saya');
    Route::get('/riwayat/{anggota}', [PeminjamanController::class, 'riwayat'])->name('riwayat.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('permission:ubah profil sendiri')->name('profile.destroy');
});

require __DIR__.'/auth.php';