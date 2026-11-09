<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Membuat 12 permission
        $permissions = [
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

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Membuat 3 role
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $petugas = Role::firstOrCreate([
            'name' => 'petugas',
            'guard_name' => 'web',
        ]);

        $siswa = Role::firstOrCreate([
            'name' => 'siswa',
            'guard_name' => 'web',
        ]);

        // Permission Admin
        $admin->syncPermissions($permissions);

        // Permission Petugas
        $petugas->syncPermissions([
            'akses dashboard petugas',
            'lihat daftar buku',
            'kelola data buku',
            'kelola peminjaman',
            'kelola pengembalian',
            'lihat laporan perpustakaan',
            'lihat profil sendiri',
            'ubah profil sendiri',
            'lihat riwayat peminjaman sendiri',
        ]);

        // Permission Siswa
        $siswa->syncPermissions([
            'lihat daftar buku',
            'lihat profil sendiri',
            'ubah profil sendiri',
            'lihat riwayat peminjaman sendiri',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
