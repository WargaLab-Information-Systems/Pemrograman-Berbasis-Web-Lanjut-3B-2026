
@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="container" style="max-width:650px;padding:35px 20px;">

    <h1 style="font-size:26px;font-weight:bold;margin-bottom:20px;">
        Tambah Pengguna
    </h1>

    {{-- PESAN ERROR --}}
    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:15px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDASI --}}
    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:15px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('pengguna.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:15px;">
            <label>Nama Lengkap</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                class="w-full rounded border p-2">
        </div>

        <div style="margin-bottom:15px;">
            <label>Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="w-full rounded border p-2">
        </div>

        <div style="margin-bottom:15px;">
            <label>Password</label>
            <input
                type="password"
                name="password"
                required
                minlength="8"
                class="w-full rounded border p-2">
        </div>

        <div style="margin-bottom:20px;">
            <label>Role Pengguna</label>

            <select name="role" required class="w-full rounded border p-2">
                <option value="">-- Pilih Role --</option>

                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>

                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>
                    Petugas
                </option>

                <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>
                    Siswa
                </option>
            </select>
        </div>

        <button type="submit" class="btn-primary">
            Simpan Pengguna
        </button>

        <a href="{{ route('pengguna.index') }}"
           style="margin-left:10px;">
            Kembali
        </a>
    </form>

</div>
@endsection
