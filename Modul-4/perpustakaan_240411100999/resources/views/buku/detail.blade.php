@extends('layouts.app')

@section('title', 'Detail Buku - PerpustakaanKu')

@section('content')

    <section class="page-heading">
        <h2>Detail Buku</h2>
        <p>Informasi lengkap mengenai buku yang dipilih.</p>
    </section>

    @if ($buku)

        <div class="detail-card">

            

            <h2>{{ $buku['judul'] }}</h2>

            <div class="detail-info">
                <p>
                    <strong>ID Buku:</strong>
                    {{ $buku['id'] }}
                </p>

                <p>
                    <strong>Penulis:</strong>
                    {{ $buku['penulis'] }}
                </p>

                <p>
                    <strong>Tahun Terbit:</strong>
                    {{ $buku['tahun'] }}
                </p>

                <p>
                    <strong>Kategori:</strong>
                    {{ $buku['kategori'] }}
                </p>

                <p>
                    <strong>Deskripsi:</strong>
                    {{ $buku['deskripsi'] }}
                </p>
            </div>

            <a href="{{ route('buku.index') }}" class="btn">
                Kembali ke Daftar Buku
            </a>

        </div>

    @else

        <div class="not-found">
            <h2>Buku Tidak Ditemukan</h2>
            <p>Maaf, data buku dengan ID tersebut tidak tersedia.</p>

            <a href="{{ route('buku.index') }}" class="btn">
                Kembali ke Daftar Buku
            </a>
        </div>

    @endif

@endsection