
@extends('layouts.app')

@section('title', 'Data Peminjaman - PerpustakaanKu')

@section('content')

<style>
    .loan-page {
        background: #f8f3ec;
        min-height: 80vh;
        padding: 55px 20px;
        color: #3d2e23;
    }

    .loan-container {
        max-width: 1100px;
        margin: auto;
    }

    .loan-heading {
        margin-bottom: 30px;
    }

    .loan-heading h1 {
        color: #5b4636;
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .loan-heading p {
        color: #806e5e;
        margin: 0;
    }

    .loan-card {
        background: white;
        border-radius: 16px;
        padding: 22px;
        margin-bottom: 16px;
        box-shadow: 0 5px 18px rgba(61, 46, 35, 0.07);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .loan-info h3 {
        font-size: 18px;
        color: #5b4636;
        margin: 0 0 10px;
        font-weight: 700;
    }

    .loan-info p {
        margin: 5px 0;
        color: #766657;
        font-size: 14px;
    }

    .loan-status {
        display: inline-block;
        padding: 7px 13px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 10px;
    }

    .status-done {
        background: #e4f3e7;
        color: #28743b;
    }

    .status-pending {
        background: #fff0d9;
        color: #98621c;
    }

    .btn-return {
        background: #5b4636;
        color: white;
        border: none;
        padding: 11px 20px;
        border-radius: 9px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-return:hover {
        background: #3d2e23;
    }

    .empty-loan {
        background: white;
        padding: 45px 20px;
        text-align: center;
        border-radius: 16px;
        color: #806e5e;
    }

    .alert-success {
        background: #e4f3e7;
        color: #28743b;
        padding: 13px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .alert-error {
        background: #fde8e7;
        color: #a52d2d;
        padding: 13px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    @media (max-width: 600px) {
        .loan-heading h1 {
            font-size: 25px;
        }

        .loan-card {
            padding: 18px;
        }

        .btn-return {
            width: 100%;
        }
    }
</style>

<div class="loan-page">
    <div class="loan-container">

        <div class="loan-heading">
            <h1>Data Peminjaman</h1>
            <p>Kelola data peminjaman dan pengembalian buku perpustakaan.</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @forelse($peminjaman as $item)
            <div class="loan-card">

                <div class="loan-info">
                    <h3>{{ $item->buku->judul }}</h3>

                    <p><strong>Nama Anggota:</strong> {{ $item->anggota->nama }}</p>
                    <p><strong>Tanggal Pinjam:</strong> {{ $item->tanggal_pinjam }}</p>
                    <p><strong>Batas Kembali:</strong> {{ $item->tanggal_kembali }}</p>

                    @if($item->tanggal_dikembalikan)
                        <span class="loan-status status-done">
                            ✓ Sudah Dikembalikan
                        </span>
                        <p><strong>Tanggal Dikembalikan:</strong> {{ $item->tanggal_dikembalikan }}</p>
                    @else
                        <span class="loan-status status-pending">
                            Belum Dikembalikan
                        </span>
                    @endif
                </div>

                @if(!$item->tanggal_dikembalikan)
                    <form method="POST"
                          action="{{ route('peminjaman.kembalikan', $item->id) }}"
                          onsubmit="return confirm('Yakin ingin mencatat pengembalian buku ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-return">
                            Kembalikan Buku
                        </button>
                    </form>
                @endif

            </div>
        @empty
            <div class="empty-loan">
                <h3>Belum Ada Peminjaman</h3>
                <p>Data peminjaman buku belum tersedia.</p>
            </div>
        @endforelse

    </div>
</div>

@endsection
