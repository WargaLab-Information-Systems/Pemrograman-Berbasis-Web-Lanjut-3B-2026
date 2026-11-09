@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="container" style="padding:35px 20px;">

    <h1 style="font-size:28px;font-weight:bold;margin-bottom:8px;">
        Kelola Data Pengguna
    </h1>

    <p style="color:#64748b;margin-bottom:25px;">
        Kelola akun Admin, Petugas, dan Siswa.
    </p>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px;border-radius:8px;margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:15px;">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('pengguna.create') }}"
       class="btn-primary"
       style="display:inline-block;margin-bottom:20px;">
        + Tambah Pengguna
    </a>

    <div style="overflow-x:auto;background:white;border-radius:12px;">
        <table style="width:100%;border-collapse:collapse;">
            <thead style="background:#f1f5f9;">
                <tr>
                    <th style="padding:14px;text-align:left;">No</th>
                    <th style="padding:14px;text-align:left;">Nama</th>
                    <th style="padding:14px;text-align:left;">Email</th>
                    <th style="padding:14px;text-align:left;">Role</th>
                    <th style="padding:14px;text-align:left;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengguna as $item)
                    <tr style="border-top:1px solid #e2e8f0;">
                        <td style="padding:14px;">{{ $loop->iteration }}</td>
                        <td style="padding:14px;">{{ $item->name }}</td>
                        <td style="padding:14px;">{{ $item->email }}</td>
                        <td style="padding:14px;">
                            {{ $item->getRoleNames()->implode(', ') ?: '-' }}
                        </td>
                        <td style="padding:14px;white-space:nowrap;">
                            <a href="{{ route('pengguna.edit', $item->id) }}"
                               class="btn-primary">
                                Edit
                            </a>

                            @if($item->id !== auth()->id())
                                <form action="{{ route('pengguna.destroy', $item->id) }}"
                                      method="POST"
                                      style="display:inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            style="background:#dc2626;color:white;padding:9px 13px;border-radius:6px;">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:25px;text-align:center;">
                            Belum ada data pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection