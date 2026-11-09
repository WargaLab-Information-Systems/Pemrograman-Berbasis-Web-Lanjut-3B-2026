@extends('layouts.app')

@section('title', 'Dashboard - PerpustakaanKu')

@section('content')

<section class="page-header">
    <div class="container">
        <span class="badge">📚 Dashboard</span>

        <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>

        <p>
            Selamat datang di Sistem Informasi PerpustakaanKu.
            Kelola seluruh aktivitas perpustakaan melalui dashboard ini.
        </p>
    </div>
</section>

<section class="book-section">
    <div class="container">

        <div class="feature-grid">

            {{-- KELOLA BUKU --}}
            @can('kelola data buku')
                <div class="feature-card">
                    <div class="feature-icon">📚</div>
                    <h3>Kelola Data Buku</h3>
                    <p>
                        Tambah, edit, hapus, dan lihat koleksi buku
                        yang tersedia di perpustakaan.
                    </p>
                    <a href="{{ route('buku.index') }}" class="btn btn-primary">
                        Kelola Buku
                    </a>
                </div>
            @endcan

            {{-- LIHAT BUKU --}}
            @can('lihat daftar buku')
                <div class="feature-card">
                    <div class="feature-icon">📖</div>
                    <h3>Daftar Buku</h3>
                    <p>
                        Lihat koleksi dan informasi detail buku
                        yang tersedia di perpustakaan.
                    </p>
                    <a href="{{ route('buku.index') }}" class="btn btn-primary">
                        Lihat Buku
                    </a>
                </div>
            @endcan

            {{-- KELOLA PENGGUNA: KHUSUS ADMIN --}}
            @can('kelola data pengguna')
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Kelola Pengguna</h3>
                    <p>
                        Tambah, edit, hapus, dan atur role
                        pengguna sistem perpustakaan.
                    </p>
                    <a href="{{ route('pengguna.index') }}" class="btn btn-primary">
                        Kelola Pengguna
                    </a>
                </div>
            @endcan

            {{-- KELOLA PEMINJAMAN --}}
            @can('kelola peminjaman')
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h3>Kelola Peminjaman</h3>
                    <p>
                        Kelola data peminjaman buku dan aktivitas
                        anggota perpustakaan.
                    </p>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-primary">
                        Kelola Peminjaman
                    </a>
                </div>
            @endcan

            {{-- RIWAYAT PEMINJAMAN: SISWA --}}
            @role('siswa')
                @can('lihat riwayat peminjaman sendiri')
                    <div class="feature-card">
                        <div class="feature-icon">📚</div>
                        <h3>Riwayat Peminjaman</h3>
                        <p>
                            Lihat daftar buku yang pernah dipinjam
                            dan status pengembaliannya.
                        </p>
                        <a href="{{ route('peminjaman.riwayat') }}" class="btn btn-primary">
                            Lihat Riwayat
                        </a>
                    </div>
                @endcan
            @endrole

        </div>

    </div>
</section>

@endsection
