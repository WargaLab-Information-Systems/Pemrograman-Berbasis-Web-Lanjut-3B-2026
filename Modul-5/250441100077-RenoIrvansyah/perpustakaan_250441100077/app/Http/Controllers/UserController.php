<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Anggota;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::with('roles')
            ->latest()
            ->get();

        return view('users.index', compact('users'));
    }

    // Menyimpan akun pengguna baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'petugas', 'siswa'])],
            'no_telepon' => 'required_if:role,siswa|nullable|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            $user->syncRoles([$validated['role']]);

            // Jika role siswa, otomatis buat data anggota
            if ($validated['role'] === 'siswa') {
                Anggota::create([
                    'user_id' => $user->id,
                    'nama' => $user->name,
                    'email' => $user->email,
                    'no_telepon' => $validated['no_telepon'],
                ]);
            }
        });

        return redirect()->route('users.index')
            ->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    // Memperbarui akun pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Mengubah role pengguna
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => ['required', Rule::in(['admin', 'petugas', 'siswa'])],
        ]);

        $user = User::findOrFail($id);

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')
            ->with('success', 'Role pengguna berhasil diperbarui.');
    }

    // Menghapus akun pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
