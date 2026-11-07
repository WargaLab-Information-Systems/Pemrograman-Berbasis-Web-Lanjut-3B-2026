@extends('layouts.perpus')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                Riwayat Peminjaman
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Lihat daftar buku yang pernah kamu pinjam di perpustakaan.
            </p>
        </div>

        {{-- Tabel Riwayat --}}
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-6 py-5">
                <h2 class="text-lg font-semibold text-gray-800">
                    Daftar Riwayat Buku
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Informasi peminjaman dan pengembalian buku.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">

                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-6 py-4">No.</th>
                            <th class="px-6 py-4">Judul Buku</th>
                            <th class="px-6 py-4">Tanggal Pinjam</th>
                            <th class="px-6 py-4">Tanggal Kembali</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-gray-700">

                        @forelse ($peminjamans as $index => $peminjaman)
                            <tr class="transition hover:bg-gray-50">

                                <td class="px-6 py-4">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4 font-medium">
                                    {{ $peminjaman->buku->judul }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $peminjaman->tanggal_kembali ? $peminjaman->tanggal_kembali->format('d-m-Y') : '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    @if ($peminjaman->tanggal_kembali)
                                        <span
                                            class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    Kamu belum memiliki riwayat peminjaman buku.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
