@extends('layouts.app')

@section('title', 'Detail Buku - PerpustakaanKu')

@section('content')

<section class="detail-section">
    <div class="container">

        @if($buku)

            <a href="{{ route('web.buku.index') }}" class="back-link">
                ← Kembali ke Daftar Buku
            </a>

            <div class="detail-card">

                <div class="detail-cover">
                    <span>📖</span>
                </div>

                <div class="detail-info">

                    <span class="category">
                        {{ $buku['kategori'] }}
                    </span>

                    <h1>{{ $buku['judul'] }}</h1>

                    <div class="detail-list">

                        <div>
                            <span>Penulis</span>
                            <strong>{{ $buku['penulis'] }}</strong>
                        </div>

                        <div>
                            <span>Tahun Terbit</span>
                            <strong>{{ $buku['tahun'] }}</strong>
                        </div>

                        <div>
                            <span>Kategori</span>
                            <strong>{{ $buku['kategori'] }}</strong>
                        </div>

                        <div>
                            <span>ID Buku</span>
                            <strong>{{ $buku['id'] }}</strong>
                        </div>

                    </div>

                    <p class="detail-description">
                        Buku ini merupakan salah satu koleksi PerpustakaanKu
                        yang dapat digunakan sebagai sumber bacaan dan
                        pengetahuan.
                    </p>

                </div>

            </div>

        @else

            <div class="empty-state">
                <div>🔍</div>
                <h2>Buku Tidak Ditemukan</h2>
                <p>
                    Data buku dengan ID tersebut tidak tersedia.
                </p>

                <a href="{{ route('web.buku.index') }}" class="btn-primary">
                    Kembali ke Daftar Buku
                </a>
            </div>

        @endif

    </div>
</section>

@endsection