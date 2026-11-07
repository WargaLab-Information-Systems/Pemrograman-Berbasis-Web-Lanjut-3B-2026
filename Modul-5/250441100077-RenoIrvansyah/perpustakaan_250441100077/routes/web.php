
<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {

    // Daftar Buku (Admin, Petugas, Siswa)
    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat daftar buku')
        ->name('buku.index');

    // Detail Buku (Admin, Petugas, Siswa)
    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->middleware('permission:lihat daftar buku')
        ->name('buku.detail');

    // Kelola Buku (Admin dan Petugas)
    Route::get('/admin/buku', [BukuController::class, 'kelola'])
        ->middleware('permission:kelola data buku')
        ->name('buku.kelola');

    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })
        ->middleware('permission:akses dashboard admin')
        ->name('admin.dashboard');

    // Dashboard Petugas
    Route::get('/petugas/dashboard', function () {
        return view('dashboard.petugas');
    })
        ->middleware('permission:akses dashboard petugas')
        ->name('petugas.dashboard');

    // Dashboard berdasarkan Role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        return redirect()->route('buku.index');
    })->name('dashboard');

    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat profil sendiri')
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('permission:ubah profil sendiri')
        ->name('profile.destroy');

    // Peminjaman (Admin dan Petugas)
    Route::middleware('permission:kelola peminjaman')->group(function () {
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])
            ->name('peminjaman.index');

        Route::post('/peminjaman', [PeminjamanController::class, 'store'])
            ->name('peminjaman.store');
    });

    // Riwayat Peminjaman (Admin, Petugas, Siswa)
    Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayat'])
        ->middleware('permission:lihat riwayat peminjaman sendiri')
        ->name('peminjaman.riwayat');

    // Pengembalian (Admin dan Petugas)
    Route::middleware('permission:kelola pengembalian')->group(function () {
        Route::get('/pengembalian', [PeminjamanController::class, 'pengembalian'])
            ->name('pengembalian.index');

        Route::patch('/pengembalian/{id}', [PeminjamanController::class, 'kembalikan'])
            ->name('pengembalian.kembalikan');
    });

    // Laporan Perpustakaan (Admin)
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')
        ->name('laporan.index');

    // Manajemen Akun Pengguna
    Route::middleware('permission:kelola data pengguna')->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::post('/admin/users', [UserController::class, 'store'])
            ->name('users.store');

        Route::put('/admin/users/{id}', [UserController::class, 'update'])
            ->name('users.update');

        Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])
            ->name('users.destroy');
    });

    // Manajemen Role Pengguna
    Route::put('/admin/users/{id}/role', [UserController::class, 'updateRole'])
        ->middleware('permission:kelola role pengguna')
        ->name('users.updateRole');
});

require __DIR__ . '/auth.php';
