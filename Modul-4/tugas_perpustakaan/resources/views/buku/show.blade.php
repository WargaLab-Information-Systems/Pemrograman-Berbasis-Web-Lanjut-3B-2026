@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-700">Detail Informasi Buku</h2>
        <!-- Menggunakan $id, BUKAN $buku->id -->
        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">ID: {{ $id }}</span>
    </div>

    <!-- Data diisi oleh JavaScript melalui id elemen -->
    <div class="space-y-4">
        <div class="flex justify-between border-b py-3">
            <span class="font-semibold text-gray-600">Judul Buku</span>
            <span id="buku-judul" class="text-gray-900 font-bold text-lg">Memuat...</span>
        </div>
        <div class="flex justify-between border-b py-3">
            <span class="font-semibold text-gray-600">Kategori</span>
            <span id="buku-kategori" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">Memuat...</span>
        </div>
        <div class="flex justify-between border-b py-3">
            <span class="font-semibold text-gray-600">Penulis</span>
            <span id="buku-penulis" class="text-gray-800">Memuat...</span>
        </div>
        <div class="flex justify-between border-b py-3">
            <span class="font-semibold text-gray-600">Tahun Terbit</span>
            <span id="buku-tahun" class="text-gray-800">Memuat...</span>
        </div>
    </div>

    <div class="mt-8 flex justify-end">
        <a href="{{ url('/buku') }}" class="bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-700 font-medium">
            &laquo; Kembali ke Daftar Buku
        </a>
    </div>
</div>

<script>
// Mengambil $id dari Blade
const bukuId = {{ $id }};

async function loadDetailBuku() {
    try {
        const response = await fetch(`/api/buku/${bukuId}`);
        if (!response.ok) throw new Error('Data buku tidak ditemukan.');

        const result = await response.json();
        const buku = result.data;

        // Mengisi elemen UI dengan data dari API
        document.getElementById('buku-judul').innerText = buku.judul;
        document.getElementById('buku-kategori').innerText = buku.kategori;
        document.getElementById('buku-penulis').innerText = buku.penulis;
        document.getElementById('buku-tahun').innerText = buku.tahun;

    } catch (error) {
        alert(error.message);
        window.location.href = '/buku';
    }
}

document.addEventListener('DOMContentLoaded', loadDetailBuku);
</script>
@endsection