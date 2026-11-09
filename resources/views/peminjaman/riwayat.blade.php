@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - PerpustakaanKu')

@push('styles')
<style>
    .loan-container {
        max-width: 1100px;
        margin: 45px auto;
        padding: 0 24px;
    }

    .loan-header {
        margin-bottom: 30px;
    }

    .loan-heading {
        font-size: 30px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .loan-subtitle {
        color: #64748b;
        font-size: 15px;
    }

    .loan-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,.04);
        transition: .2s;
    }

    .loan-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,.08);
    }

    .loan-title {
        font-size: 19px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .loan-detail {
        color: #64748b;
        font-size: 14px;
        margin: 6px 0;
    }

    .loan-status {
        display: inline-block;
        padding: 7px 13px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        margin-top: 12px;
    }

    .loan-done {
        background: #dcfce7;
        color: #15803d;
    }

    .loan-pending {
        background: #fef3c7;
        color: #b45309;
    }

    .loan-empty {
        text-align: center;
        background: #fff;
        border: 1px dashed #cbd5e1;
        border-radius: 14px;
        padding: 55px 20px;
        color: #64748b;
    }

    .loan-empty-icon {
        font-size: 48px;
        margin-bottom: 12px;
    }

    .loan-empty h3 {
        font-size: 20px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
    }

    @media (max-width: 600px) {
        .loan-container {
            margin: 25px auto;
            padding: 0 15px;
        }

        .loan-heading {
            font-size: 24px;
        }

        .loan-card {
            padding: 18px;
        }
    }
</style>
@endpush

@section('content')
<div class="loan-container">

    <div class="loan-header">
        <h1 class="loan-heading">📚 Riwayat Peminjaman Saya</h1>
        <p class="loan-subtitle">
            Lihat daftar buku yang pernah dan sedang kamu pinjam.
        </p>
    </div>

    @forelse($peminjaman as $item)
        <div class="loan-card">
            <div>
                <h3 class="loan-title">
                    {{ $item->buku->judul ?? 'Buku tidak ditemukan' }}
                </h3>

                <p class="loan-detail">
                    📅 Tanggal Pinjam:
                    {{ $item->tanggal_pinjam }}
                </p>

                <p class="loan-detail">
                    ⏰ Batas Pengembalian:
                    {{ $item->tanggal_kembali }}
                </p>

                @if($item->tanggal_dikembalikan)
                    <span class="loan-status loan-done">
                        ✓ Sudah Dikembalikan
                    </span>
                @else
                    <span class="loan-status loan-pending">
                        ● Belum Dikembalikan
                    </span>
                @endif
            </div>
        </div>
    @empty
        <div class="loan-empty">
            <div class="loan-empty-icon">📖</div>
            <h3>Belum Ada Riwayat</h3>
            <p>Kamu belum memiliki riwayat peminjaman buku.</p>
        </div>
    @endforelse

</div>
@endsection
