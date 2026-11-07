@extends('layouts.app')

@section('title', 'Beranda - PerpustakaanKu')

@section('content')

    <section class="hero">
        <h2>Selamat Datang di PerpustakaanKu</h2>

        <p>
            Perpustakaan digital sederhana yang menyediakan berbagai
            koleksi buku untuk menambah wawasan dan pengetahuan.
        </p>

        <a href="{{ route('buku.index') }}" class="btn">
            Lihat Daftar Buku
        </a>
    </section>

    <section class="info">
        <h2>Jelajahi Koleksi Buku</h2>
        <p>
            Temukan berbagai buku mulai dari novel, fantasi,
            sejarah, hingga pengembangan diri.
        </p>
    </section>

@endsection