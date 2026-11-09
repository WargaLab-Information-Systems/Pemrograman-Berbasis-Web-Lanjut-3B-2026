<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Pengguna dan Role</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('sukses'))
                <p class="rounded bg-green-100 p-3 text-green-700">{{ session('sukses') }}</p>
            @endif
            @if (session('gagal'))
                <p class="rounded bg-red-100 p-3 text-red-700">{{ session('gagal') }}</p>
            @endif
            @if ($errors->any())
                <p class="rounded bg-red-100 p-3 text-red-700">{{ $errors->first() }}</p>
            @endif

            <div class="overflow-x-auto rounded-lg bg-white shadow-sm">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr><th class="p-3">Nama</th><th class="p-3">Email</th><th class="p-3">Role</th><th class="p-3">Aksi</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr class="border-t">
                                <td class="p-3">{{ $u->name }}</td>
                                <td class="p-3">{{ $u->email }}</td>
                                <td class="p-3">{{ $u->getRoleNames()->implode(', ') }}</td>
                                <td class="flex flex-wrap items-center gap-3 p-3">
                                    @can('kelola role pengguna')
                                        <form method="POST" action="{{ route('admin.pengguna.role', $u) }}" class="inline-flex gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="rounded border-gray-300 text-sm">
                                                @foreach ($roles as $r)
                                                    <option value="{{ $r->name }}" @selected($u->hasRole($r->name))>{{ $r->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="rounded bg-blue-600 px-3 py-1 text-white">Simpan Role</button>
                                        </form>
                                    @endcan

                                    @can('kelola data pengguna')
                                        <form method="POST" action="{{ route('admin.pengguna.destroy', $u) }}"
                                              onsubmit="return confirm('Hapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>