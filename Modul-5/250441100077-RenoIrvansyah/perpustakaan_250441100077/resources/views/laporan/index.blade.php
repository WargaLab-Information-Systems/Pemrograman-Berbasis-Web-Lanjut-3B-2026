@extends('layouts.perpus')

@section('title', 'Laporan Perpustakaan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Laporan Perpustakaan
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Ringkasan data koleksi buku, anggota, dan transaksi perpustakaan.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Total Buku</p>
            <h2 class="mt-2 text-3xl font-bold text-gray-800">
                {{ $totalBuku }}
            </h2>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Total Anggota</p>
            <h2 class="mt-2 text-3xl font-bold text-gray-800">
                {{ $totalAnggota }}
            </h2>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Total Transaksi Peminjaman</p>
            <h2 class="mt-2 text-3xl font-bold text-gray-800">
                {{ $totalPeminjaman }}
            </h2>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Transaksi Sedang Dipinjam</p>
            <h2 class="mt-2 text-3xl font-bold text-amber-600">
                {{ $sedangDipinjam }}
            </h2>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-sm text-gray-500">Transaksi Sudah Dikembalikan</p>
            <h2 class="mt-2 text-3xl font-bold text-green-600">
                {{ $sudahDikembalikan }}
            </h2>
        </div>

    </div>

    {{-- Tabel Riwayat Transaksi --}}
    <div class="mt-8 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

        <div class="border-b border-gray-100 px-6 py-5">
            <h2 class="text-lg font-semibold text-gray-800">
                Riwayat Transaksi Peminjaman
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Daftar seluruh transaksi peminjaman dan pengembalian.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">Nama Anggota</th>
                        <th class="px-6 py-4">Judul Buku</th>
                        <th class="px-6 py-4">Tanggal Pinjam</th>
                        <th class="px-6 py-4">Tanggal Kembali</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse ($peminjamans as $index => $peminjaman)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                {{ $peminjamans->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $peminjaman->anggota->nama }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $peminjaman->buku->judul }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $peminjaman->tanggal_kembali
                                    ? $peminjaman->tanggal_kembali->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($peminjaman->tanggal_kembali)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Dikembalikan
                                    </span>
                                @else
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700">
                                        Dipinjam
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                Belum ada transaksi peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-100 px-6 py-4">
            {{ $peminjamans->links() }}
        </div>

    </div>
</div>
@endsection
