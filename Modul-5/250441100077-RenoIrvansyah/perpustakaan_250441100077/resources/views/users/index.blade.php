@extends('layouts.perpus')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                Manajemen Pengguna
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Kelola akun dan hak akses pengguna perpustakaan.
            </p>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-5 rounded-lg bg-green-100 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 rounded-lg bg-red-100 p-4 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form Tambah Pengguna --}}
        <div class="mb-8 rounded-xl border border-gray-100 bg-white p-6 shadow-sm">

            <h2 class="mb-5 text-lg font-semibold text-gray-800">
                Tambah Akun Pengguna
            </h2>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <input type="password" name="password" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Role Pengguna
                        </label>
                        <select name="role" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Nomor Telepon
                        </label>

                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                            placeholder="Masukkan nomor telepon"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm">

                        @error('no_telepon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <p class="mt-1 text-xs text-gray-500">
                            Wajib diisi jika role yang dipilih adalah Siswa.
                        </p>
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="rounded-lg bg-[#a82a2a] px-6 py-3 text-sm font-medium text-white transition hover:bg-red-800">
                        Tambah Pengguna
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Pengguna --}}
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-6 py-5">
                <h2 class="text-lg font-semibold text-gray-800">
                    Daftar Pengguna
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Daftar akun yang terdaftar pada sistem perpustakaan.
                </p>
            </div>



            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">

                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-6 py-4">No.</th>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Ubah Role</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-gray-700">

                        @forelse ($users as $index => $user)
                            <tr class="transition hover:bg-gray-50">

                                <td class="px-6 py-4">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4 font-medium">
                                    {{ $user->name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4">
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="rounded-full px-3 py-1 text-xs font-medium
                                        {{ $role->name === 'admin' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $role->name === 'petugas' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $role->name === 'siswa' ? 'bg-green-100 text-green-700' : '' }}">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </td>

                                {{-- Ubah Role --}}
                                <td class="px-6 py-4">
                                    @can('kelola role pengguna')
                                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST"
                                            class="flex items-center gap-2">
                                            @csrf
                                            @method('PUT')

                                            <select name="role" class="rounded-lg border border-gray-300 px-2 py-2 text-xs">
                                                <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>
                                                    Admin
                                                </option>
                                                <option value="petugas" {{ $user->hasRole('petugas') ? 'selected' : '' }}>
                                                    Petugas
                                                </option>
                                                <option value="siswa" {{ $user->hasRole('siswa') ? 'selected' : '' }}>
                                                    Siswa
                                                </option>
                                            </select>

                                            <button type="submit"
                                                class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700">
                                                Simpan
                                            </button>
                                        </form>
                                    @endcan
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">

                                        {{-- Edit --}}
                                        <button type="button"
                                            onclick="document.getElementById('edit-user-{{ $user->id }}').classList.remove('hidden')"
                                            class="rounded-lg bg-amber-100 px-3 py-2 text-xs font-medium text-amber-700 hover:bg-amber-200">
                                            Edit
                                        </button>

                                        {{-- Hapus --}}
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="rounded-lg bg-red-100 px-3 py-2 text-xs font-medium text-red-700 hover:bg-red-200">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                            {{-- Form Edit Pengguna --}}
                            <tr id="edit-user-{{ $user->id }}" class="hidden bg-gray-50">
                                <td colspan="6" class="px-6 py-5">

                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <h3 class="mb-4 font-semibold text-gray-800">
                                            Edit Pengguna: {{ $user->name }}
                                        </h3>

                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                                            <input type="text" name="name" value="{{ $user->name }}" required
                                                placeholder="Nama lengkap"
                                                class="rounded-lg border border-gray-300 px-4 py-3 text-sm">

                                            <input type="email" name="email" value="{{ $user->email }}" required
                                                placeholder="Email"
                                                class="rounded-lg border border-gray-300 px-4 py-3 text-sm">

                                            <input type="password" name="password" placeholder="Password baru (opsional)"
                                                class="rounded-lg border border-gray-300 px-4 py-3 text-sm">

                                            <input type="password" name="password_confirmation"
                                                placeholder="Konfirmasi password baru"
                                                class="rounded-lg border border-gray-300 px-4 py-3 text-sm">

                                        </div>

                                        <div class="mt-4 flex gap-2">
                                            <button type="submit"
                                                class="rounded-lg bg-[#a82a2a] px-5 py-2 text-sm font-medium text-white hover:bg-red-800">
                                                Simpan Perubahan
                                            </button>

                                            <button type="button"
                                                onclick="document.getElementById('edit-user-{{ $user->id }}').classList.add('hidden')"
                                                class="rounded-lg border border-gray-300 px-5 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                                Batal
                                            </button>
                                        </div>

                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada pengguna terdaftar.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
