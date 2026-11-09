<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminPenggunaController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('id')->get();
        $roles = Role::orderBy('name')->get();

        return view('admin.pengguna.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::exists('roles', 'name')],
        ]);

        if ($user->id === $request->user()->id && $data['role'] !== 'admin') {
            return back()->with('gagal', 'Anda tidak dapat menurunkan role akun Anda sendiri.');
        }

        $user->syncRoles([$data['role']]);

        return back()->with('sukses', 'Role '.$user->name.' diubah menjadi '.$data['role'].'.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('gagal', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('sukses', 'Akun pengguna berhasil dihapus.');
    }
}