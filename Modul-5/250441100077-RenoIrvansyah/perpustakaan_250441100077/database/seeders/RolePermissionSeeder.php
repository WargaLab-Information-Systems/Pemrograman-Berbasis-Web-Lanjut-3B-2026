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

        $admin->syncPermissions($permissions);

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

        $siswa->syncPermissions([
            'lihat daftar buku',
            'lihat profil sendiri',
            'ubah profil sendiri',
            'lihat riwayat peminjaman sendiri',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
