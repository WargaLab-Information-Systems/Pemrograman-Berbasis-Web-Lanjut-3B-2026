<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@ribuan-kata.com'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => 'password123',
            ]
        );

        $admin->syncRoles(['admin']);

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@ribuan-kata.com'],
            [
                'name' => 'Petugas Perpustakaan',
                'password' => 'password123',
            ]
        );

        $petugas->syncRoles(['petugas']);

        // Membuat akun Siswa
        $siswa = User::firstOrCreate(
            ['email' => 'siswa@ribuan-kata.com'],
            [
                'name' => 'Siswa Perpustakaan',
                'password' => 'password123',
            ]
        );

        $siswa->syncRoles(['siswa']);
    }
}
