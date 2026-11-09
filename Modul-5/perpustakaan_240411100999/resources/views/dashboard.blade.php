<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <p>Selamat datang, {{ auth()->user()->name }}!</p>

                @can('lihat daftar buku')
                    <a href="{{ route('buku.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Lihat Daftar Buku</a>
                @endcan
                @can('lihat riwayat peminjaman sendiri')
                    <a href="{{ route('riwayat.saya') }}" class="mt-4 ms-4 inline-block text-blue-600 hover:underline">Riwayat Peminjaman Saya</a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>