<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Peminjaman</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (! $anggota)
                <div class="rounded bg-yellow-100 p-4 text-yellow-800">
                    Akun Anda belum terhubung dengan data anggota perpustakaan. Hubungi petugas atau admin.
                </div>
            @else
                <x-tabel-generik :rows="$data" />
            @endif
        </div>
    </div>
</x-app-layout>