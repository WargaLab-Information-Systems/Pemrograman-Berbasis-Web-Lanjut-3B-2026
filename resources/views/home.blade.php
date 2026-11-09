@extends('layouts.app')

@section('title', 'Beranda - PerpustakaanKu')

@section('content')

<section class="hero">
    <div class="container hero-content">

        <div class="hero-text">
            <span class="badge">📖 Selamat Datang</span>

            <h1>
                Temukan Buku Favoritmu
                <span>di PerpustakaanKu</span>
            </h1>

            <p>
                Jelajahi berbagai koleksi buku pilihan untuk menambah
                wawasan, pengetahuan, dan inspirasi.
            </p>

            <a href="{{ route('buku.index') }}" class="btn-primary">
                Jelajahi Buku →
            </a>
        </div>

        <div class="hero-book">
            <div class="book-icon">📚</div>
            <h3>Perpustakaan Digital</h3>
            <p>Belajar tanpa batas.</p>
        </div>

    </div>
</section>

<section class="features">
    <div class="container">

        <div class="section-heading">
            <span>Koleksi Kami</span>
            <h2>Kenapa Membaca?</h2>
            <p>
                Membaca membuka jendela menuju pengetahuan dan pengalaman baru.
            </p>
        </div>

        <div class="feature-grid">

            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h3>Beragam Koleksi</h3>
                <p>
                    Temukan berbagai jenis buku dengan kategori yang beragam.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">💡</div>
                <h3>Tambah Wawasan</h3>
                <p>
                    Dapatkan pengetahuan dan perspektif baru melalui membaca.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">✨</div>
                <h3>Inspirasi</h3>
                <p>
                    Temukan ide dan inspirasi dari berbagai cerita dan karya.
                </p>
            </div>

        </div>

    </div>
</section>

@endsection