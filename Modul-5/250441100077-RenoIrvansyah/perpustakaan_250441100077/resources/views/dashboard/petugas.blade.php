@extends('layouts.perpus')

@section('title', 'Dashboard Petugas')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Dashboard Petugas
        </h1>

        <p class="mt-2 text-gray-600">
            Selamat datang, {{ auth()->user()->name }}!
        </p>

        <p class="mt-4">
            Anda login sebagai Petugas Perpustakaan.
        </p>
    </div>
@endsection
