@extends('layouts.perpus')

@section('title', 'Pengembalian Buku')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Pengembalian Buku
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Daftar buku yang masih dalam proses peminjaman.
            </p>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl bg-white shadow">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-5 py-4">No.</th>
                        <th class="px-5 py-4">Nama Anggota</th>
                        <th class="px-5 py-4">Judul Buku</th>
                        <th class="px-5 py-4">Tanggal Pinjam</th>
                        <th class="px-5 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($peminjamans as $index => $peminjaman)
                        <tr>
                            <td class="px-5 py-4">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $peminjaman->anggota->nama }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $peminjaman->buku->judul }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}
                            </td>

                            <td class="px-5 py-4">
                                <form action="{{ route('pengembalian.kembalikan', $peminjaman->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin memproses pengembalian buku ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700">
                                        Kembalikan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                                Tidak ada buku yang sedang dipinjam.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
