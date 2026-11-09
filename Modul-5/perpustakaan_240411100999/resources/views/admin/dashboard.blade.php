<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <p>Selamat datang, {{ auth()->user()->name }}!</p>

                @can('kelola data pengguna')
                    <div class="mt-4 rounded bg-green-100 p-3 text-green-800">
                        Anda memiliki hak akses untuk <strong>kelola pengguna</strong>.
                    </div>
                @endcan

                <div class="mt-4 flex flex-wrap gap-4 text-blue-600">
                    @can('kelola data buku') <a class="hover:underline" href="{{ route('buku.kelola') }}">Kelola Buku</a> @endcan
                    @can('kelola data pengguna') <a class="hover:underline" href="{{ route('admin.pengguna.index') }}">Kelola Pengguna dan Role</a> @endcan
                    @can('kelola peminjaman') <a class="hover:underline" href="{{ route('peminjaman.index') }}">Peminjaman</a> @endcan
                    @can('kelola pengembalian') <a class="hover:underline" href="{{ route('pengembalian.index') }}">Pengembalian</a> @endcan
                    @can('lihat laporan perpustakaan') <a class="hover:underline" href="{{ route('laporan.index') }}">Laporan</a> @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>