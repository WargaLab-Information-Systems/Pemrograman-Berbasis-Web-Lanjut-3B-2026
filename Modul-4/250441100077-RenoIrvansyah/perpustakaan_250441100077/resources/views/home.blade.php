@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    <section class="relative w-full">
        <img src="{{ asset('images/perpus.jpeg') }}" alt="Perpustakaan Ribuan Kata" class="h-[600px] w-full object-cover">

        <!-- Overlay agar teks lebih mudah dibaca -->
        <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/30 px-4 text-center">
            <h1 class="text-4xl font-bold tracking-wide text-white sm:text-5xl md:text-7xl">
                SELAMAT DATANG
            </h1>

            <p class="mt-4 text-lg font-bold text-white sm:text-2xl md:text-3xl">
                DI PERPUSTAKAAN - RIBUAN KATA
            </p>
        </div>
    </section>

@endsection
