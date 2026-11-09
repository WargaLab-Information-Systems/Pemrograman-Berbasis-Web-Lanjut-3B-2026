<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    // Menampilkan semua pengguna
    public function index()
    {
        $pengguna = User::with('roles')->latest()->get();

        return view('pengguna.index', compact('pengguna'));
    }

    // Form tambah pengguna
    public function create()
    {
        return view('pengguna.create');
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => [
                'required',
                Rule::in(['admin', 'petugas', 'siswa'])
            ],
        ]);

        DB::transaction(function () use ($validated) {

            // Simpan akun ke tabel users
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Berikan role kepada pengguna
            $user->assignRole($validated['role']);

            // Jika role siswa, buat data anggota
            if ($validated['role'] === 'siswa') {
                Anggota::create([
                    'user_id' => $user->id,
                    'nama' => $user->name,
                    'email' => $user->email,
                    'no_telepon' => '-',
                ]);
            }
        });

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Form edit pengguna
    public function edit(User $pengguna)
    {
        return view('pengguna.edit', compact('pengguna'));
    }

    // Memperbarui pengguna
    public function update(Request $request, User $pengguna)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($pengguna->id),
            ],
            'password' => 'nullable|string|min:8',
            'role' => [
                'required',
                Rule::in(['admin', 'petugas', 'siswa'])
            ],
        ]);

        DB::transaction(function () use ($validated, $pengguna) {

            $pengguna->name = $validated['name'];
            $pengguna->email = $validated['email'];

            if (!empty($validated['password'])) {
                $pengguna->password = Hash::make($validated['password']);
            }

            $pengguna->save();

            // Perbarui role
            $pengguna->syncRoles([$validated['role']]);

            // Buat atau perbarui anggota jika role siswa
            if ($validated['role'] === 'siswa') {
                Anggota::updateOrCreate(
                    ['user_id' => $pengguna->id],
                    [
                        'nama' => $pengguna->name,
                        'email' => $pengguna->email,
                        'no_telepon' => '-',
                    ]
                );
            }
        });

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Menghapus pengguna
    public function destroy(User $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak dapat menghapus akun sendiri.');
        }

        if ($pengguna->anggota()->exists()) {
            return back()->with('error', 'Pengguna masih terhubung dengan data anggota.');
        }

        $pengguna->delete();

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
