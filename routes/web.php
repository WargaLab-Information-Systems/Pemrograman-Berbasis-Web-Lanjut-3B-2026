
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
// ==========================================
// HALAMAN UTAMA
// ==========================================

Route::get('/', function () {
    return view('home');
})->name('home');


// ==========================================
// DASHBOARD UMUM SETELAH LOGIN
// ==========================================

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->can('akses dashboard admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->can('akses dashboard petugas')) {
        return redirect()->route('petugas.dashboard');
    }

    return redirect()->route('buku.index');

})->middleware('auth')->name('dashboard');


// ==========================================
// DASHBOARD ADMIN
// ==========================================

Route::middleware(['auth', 'permission:akses dashboard admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

});

Route::middleware(['auth', 'permission:kelola data pengguna'])->group(function () {
    Route::resource('pengguna', PenggunaController::class)
        ->except(['show']);
});


// ==========================================
// DASHBOARD PETUGAS
// ==========================================

Route::middleware(['auth', 'permission:akses dashboard petugas'])->group(function () {

    Route::get('/petugas/dashboard', function () {
        return view('dashboard');
    })->name('petugas.dashboard');

});


// ==========================================
// KELOLA BUKU KHUSUS ADMIN
// ==========================================

Route::middleware(['auth', 'permission:kelola data buku'])->group(function () {

    // Halaman tambah buku
    Route::get('/buku/create', [BukuController::class, 'create'])
        ->name('buku.create');

    // Proses menyimpan buku
    Route::post('/buku', [BukuController::class, 'store'])
        ->name('buku.store');

    // Halaman edit buku
    Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])
        ->name('buku.edit');

    // Proses memperbarui buku
    Route::put('/buku/{id}', [BukuController::class, 'update'])
        ->name('buku.update');

    // Proses menghapus buku
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])
        ->name('buku.destroy');

});


// ==========================================
// LIHAT BUKU (ADMIN, PETUGAS, SISWA)
// ==========================================

Route::middleware(['auth', 'permission:lihat daftar buku'])->group(function () {

    // Daftar buku
    Route::get('/buku', [BukuController::class, 'index'])
        ->name('buku.index');

    // Detail buku
    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->name('buku.show');

});


// ==========================================
// PROFIL PENGGUNA
// ==========================================

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


// ==========================================
// PEMINJAMAN (ADMIN DAN PETUGAS)
// ==========================================

Route::middleware([
    'auth',
    'permission:kelola peminjaman',
])->group(function () {

    // Daftar peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    // Menyimpan peminjaman
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->name('peminjaman.store');

    // Pengembalian buku
    Route::patch('/peminjaman/{id}/kembalikan', [
        PeminjamanController::class,
        'kembalikan'
    ])->middleware('permission:kelola pengembalian')
      ->name('peminjaman.kembalikan');

});


// ==========================================
// RIWAYAT PEMINJAMAN PRIBADI
// ==========================================

Route::get('/riwayat-peminjaman', [
    PeminjamanController::class,
    'riwayatSaya'
])->middleware([
    'auth',
    'permission:lihat riwayat peminjaman sendiri'
])->name('peminjaman.riwayat');


// ==========================================
// AUTHENTICATION
// ==========================================

require __DIR__.'/auth.php';
