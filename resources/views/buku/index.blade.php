@extends('layouts.app')

@section('title', 'Daftar Buku - PerpustakaanKu')

@section('content')

<section class="page-header">
    <div class="container">

        <span class="badge">📚 Koleksi</span>

        <h1>Daftar Buku</h1>

        <p>
            Temukan buku yang menarik untuk kamu baca.
        </p>

    </div>
</section>

<section class="book-section">
    <div class="container">

        @if(count($buku) > 0)

            <div class="book-grid">

                @foreach($buku as $item)

                    <x-buku-card
                        :judul="$item['judul']"
                        :penulis="$item['penulis']"
                        :tahun="$item['tahun']"
                        :id="$item['id']"
                    >
                        <span class="category">
                            {{ $item['kategori'] }}
                        </span>
                    </x-buku-card>

                @endforeach

            </div>

        @else

            <div class="empty-state">
                <div>📚</div>
                <h2>Data buku belum tersedia</h2>
                <p>Belum ada koleksi buku yang dapat ditampilkan.</p>
            </div>

        @endif

    </div>
</section>

@endsection