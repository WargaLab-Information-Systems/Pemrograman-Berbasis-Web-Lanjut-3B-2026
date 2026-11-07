@extends('layouts.app')

@section('title', 'Daftar Buku - PerpustakaanKu')

@section('content')

    <section class="page-heading">
        <h2>Daftar Buku</h2>
        <p>Berikut adalah seluruh koleksi buku yang tersedia.</p>
    </section>

    <div class="book-grid">

        @foreach ($buku as $item)

            <x-kartu-buku :buku="$item">
                <p>
                    <strong>Kategori:</strong>
                    {{ $item['kategori'] }}
                </p>
            </x-kartu-buku>

        @endforeach

    </div>

@endsection