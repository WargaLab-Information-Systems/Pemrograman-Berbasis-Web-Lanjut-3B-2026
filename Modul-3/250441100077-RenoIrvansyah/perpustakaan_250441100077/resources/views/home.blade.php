@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    <section class="position-relative">
        <img src="{{ asset('images/perpus.jpeg') }}" class="w-100" style="height: 600px; object-fit: cover;">

        <div class="position-absolute top-50 start-50 translate-middle text-center">
            <h1 class="display-3 fw-bold">SELAMAT DATANG</h1>
            <p class="fs-4 fw-bold">DI PERPUSTAKAAN - RIBUAN KATA</p>
        </div>
    </section>

@endsection
