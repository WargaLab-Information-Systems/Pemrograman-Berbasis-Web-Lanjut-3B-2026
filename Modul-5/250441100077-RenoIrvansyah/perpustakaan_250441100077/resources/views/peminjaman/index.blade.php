@extends('layouts.perpus')

@section('title', 'Peminjaman Buku')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                Peminjaman Buku
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Kelola transaksi peminjaman buku perpustakaan.
            </p>
        </div>

        {{-- Pesan Notifikasi --}}
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

        {{-- Form Peminjaman --}}
        <div class="mb-8 rounded-xl border border-gray-100 bg-white p-6 shadow-sm">

            <h2 class="mb-5 text-lg font-semibold text-gray-800">
                Tambah Peminjaman
            </h2>

            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    {{-- Anggota --}}
                    <div>
                        <label for="anggota_id" class="mb-2 block text-sm font-medium text-gray-700">
                            Nama Anggota
                        </label>

                        <select name="anggota_id" id="anggota_id" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">

                            <option value="">Pilih Anggota</option>

                            @foreach ($anggotas as $anggota)
                                <option value="{{ $anggota->id }}"
                                    {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                    {{ $anggota->nama }}
                                </option>
                            @endforeach
                        </select>

                        @error('anggota_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buku --}}
                    <div>
                        <label for="buku_id" class="mb-2 block text-sm font-medium text-gray-700">
                            Judul Buku
                        </label>

                        <select name="buku_id" id="buku_id" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">

                            <option value="">Pilih Buku</option>

                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                    {{ $buku->judul }}
                                </option>
                            @endforeach
                        </select>

                        @error('buku_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Pinjam --}}
                    <div>
                        <label for="tanggal_pinjam" class="mb-2 block text-sm font-medium text-gray-700">
                            Tanggal Peminjaman
                        </label>

                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                            value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500">

                        @error('tanggal_pinjam')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="rounded-lg bg-[#a82a2a] px-6 py-3 text-sm font-medium text-white transition hover:bg-red-800">
                        Simpan Peminjaman
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Peminjaman --}}
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-6 py-5">
                <h2 class="text-lg font-semibold text-gray-800">
                    Daftar Peminjaman
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Seluruh riwayat transaksi peminjaman buku.
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
                            <tr class="transition hover:bg-gray-50">

                                <td class="px-6 py-4">
                                    {{ $index + 1 }}
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
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
