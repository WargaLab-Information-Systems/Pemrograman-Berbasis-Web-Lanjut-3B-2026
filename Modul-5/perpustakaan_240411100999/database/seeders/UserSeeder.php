<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->buat('admin@gmail.com', 'Administrator')->syncRoles(['admin']);
        $this->buat('petugas@gmail.com', 'Petugas Perpustakaan')->syncRoles(['petugas']);

        $siswa = $this->buat('siswa@gmail.com', 'Siswa Teladan');
        $siswa->syncRoles(['siswa']);


        if (! $siswa->anggota) {
            $anggota = Anggota::whereNull('user_id')->first();
            if ($anggota) {
                $anggota->forceFill(['user_id' => $siswa->id])->save();
            }
        }
    }

    private function buat(string $email, string $nama): User
    {
        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => $nama, 'password' => Hash::make('password')]
        );
        $user->forceFill(['email_verified_at' => now()])->save();

        return $user;
    }
}