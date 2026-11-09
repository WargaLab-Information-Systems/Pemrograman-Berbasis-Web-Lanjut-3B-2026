@extends('layouts.perpustakaan')

@section('title', 'Beranda - PerpustakaanKu')

@section('content')

    <!-- Kotak Sambutan Utama -->
    <div class="p-5 mb-4 bg-white rounded-4 shadow-sm border">
        <div class="container-fluid py-2">
            <h2 class="display-6 fw-bold text-dark mb-3">Selamat Datang di PerpustakaanKu</h2>
            <p class="col-md-10 fs-5 text-secondary mb-4">
                Perpustakaan digital sederhana yang menyediakan berbagai koleksi buku pilihan untuk menambah wawasan, literasi, dan pengetahuan Anda.
            </p>
            <a href="{{ route('buku.index') }}" class="btn btn-dark btn-lg px-4 shadow-sm">
                Lihat Daftar Buku &rarr;
            </a>
        </div>
    </div>

    <!-- Kotak Informasi Tambahan -->
    <div class="p-4 bg-white rounded-4 shadow-sm border">
        <h3 class="fw-bold text-dark fs-4 mb-2">Jelajahi Koleksi Buku</h3>
        <p class="text-secondary mb-0">
            Temukan berbagai kategori menarik mulai dari novel, fiksi, sejarah, hingga buku pengembangan diri.
        </p>
    </div>

@endsection