@extends('layouts.perpus')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Dashboard Admin
        </h1>

        <p class="mt-2 text-gray-600">
            Selamat datang, {{ auth()->user()->name }}!
        </p>

        <p class="mt-4">
            Anda login sebagai Admin Perpustakaan.
        </p>
    </div>
@endsection
