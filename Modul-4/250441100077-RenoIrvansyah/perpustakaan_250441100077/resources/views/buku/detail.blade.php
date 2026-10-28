@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

    <div class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow-md">

        <h1 class="mb-6 text-2xl font-bold text-gray-800">Detail Buku</h1>

        <div class="space-y-4">
            <div>
                <p class="text-sm text-gray-500">ID Buku</p>
                <p class="font-medium text-gray-800">{{ $buku->id }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Judul Buku</p>
                <p class="font-medium text-gray-800">{{ $buku->judul }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Kategori</p>
                <p class="font-medium text-gray-800">{{ $buku->kategori?->nama ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Penulis</p>
                <p class="font-medium text-gray-800">{{ $buku->penulis }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tahun Terbit</p>
                <p class="font-medium text-gray-800">{{ $buku->tahun_terbit }}</p>
            </div>

        </div>

        <a href="{{ route('buku.index') }}"
            class="mt-6 inline-block rounded-lg bg-gray-600 px-4 py-2 text-white hover:bg-gray-700">
            Kembali ke Daftar Buku
        </a>

    </div>

@endsection
