<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $semua = [
            'akses dashboard admin',
            'akses dashboard petugas',
            'lihat daftar buku',
            'kelola data buku',
            'kelola data pengguna',
            'kelola role pengguna',
            'kelola peminjaman',
            'kelola pengembalian',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
            'lihat riwayat peminjaman sendiri',
        ];

        foreach ($semua as $nama) {
            Permission::firstOrCreate(['name' => $nama, 'guard_name' => 'web']);
        }

        $admin   = Role::firstOrCreate(['name' => 'admin',   'guard_name' => 'web']);
        $petugas = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $siswa   = Role::firstOrCreate(['name' => 'siswa',   'guard_name' => 'web']);

        $admin->syncPermissions([
            'akses dashboard admin', 'lihat daftar buku', 'kelola data buku',
            'kelola data pengguna', 'kelola role pengguna', 'kelola peminjaman',
            'kelola pengembalian', 'lihat laporan perpustakaan', 'lihat profil sendiri',
            'ubah profil sendiri', 'lihat riwayat peminjaman sendiri',
        ]);

        $petugas->syncPermissions([
            'akses dashboard petugas', 'lihat daftar buku', 'kelola data buku',
            'kelola peminjaman', 'kelola pengembalian', 'lihat laporan perpustakaan',
            'lihat profil sendiri', 'ubah profil sendiri', 'lihat riwayat peminjaman sendiri',
        ]);

        $siswa->syncPermissions([
            'lihat daftar buku', 'lihat profil sendiri',
            'ubah profil sendiri', 'lihat riwayat peminjaman sendiri',
        ]);
    }
}