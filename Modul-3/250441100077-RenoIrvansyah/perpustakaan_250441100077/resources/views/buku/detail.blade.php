@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')

    @if ($buku)
        <div class="container py-5">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-header bg-danger text-white text-center py-3">
                    <h3 class="mb-0">Detail Buku</h3>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <img src="{{ asset('images/buku/' . $buku['poster']) }}" alt="{{ $buku['judul'] }}"
                                class="img-fluid rounded shadow" style="max-height: 450px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-4">
                                {{ $buku['judul'] }}
                            </h2>
                            <div class="mb-3">
                                <span class="text-muted">ID Buku</span>
                                <h5 class="fw-semibold">
                                    {{ $buku['id'] }}
                                </h5>
                            </div>
                            <div class="mb-3">
                                <span class="text-muted">Penulis</span>
                                <h5 class="fw-semibold">
                                    {{ $buku['penulis'] }}
                                </h5>
                            </div>
                            <div class="mb-3">
                                <span class="text-muted">Tahun Terbit</span>
                                <h5 class="fw-semibold">
                                    {{ $buku['tahun'] }}
                                </h5>
                            </div>
                            <div class="mb-4">
                                <span class="text-muted">Kategori</span>
                                <div class="mt-1">
                                    <span class="badge bg-primary fs-6">
                                        {{ $buku['kategori'] }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('buku.index') }}" class="btn btn-dark">
                                Kembali ke Daftar Buku
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container py-5">
            <div class="card border-0 shadow text-center">
                <div class="card-body py-5">
                    <h2 class="fw-bold mb-3">
                        Buku Tidak Ditemukan
                    </h2>
                    <p class="text-muted mb-4">
                        Data buku yang kamu cari tidak tersedia.
                    </p>
                    <a href="{{ route('buku.index') }}" class="btn btn-dark">
                        ← Kembali ke Daftar Buku
                    </a>
                </div>
            </div>

        </div>
    @endif

@endsection
