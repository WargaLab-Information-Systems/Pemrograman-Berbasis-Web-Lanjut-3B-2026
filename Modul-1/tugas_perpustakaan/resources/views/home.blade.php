@extends('layouts.app')

@section('content')
    <div class="bg-gradient-to-r from-blue-500 to-blue-400 w-full min-h-[350px] rounded-3xl p-12 flex flex-col items-center justify-center shadow-lg mt-4">
        
        <h2 class="text-white font-extrabold text-4xl text-center mb-8 drop-shadow-md">
            Selamat Datang di Perpustakaan Nwpiss
        </h2>
        
        <a href="{{ route('buku.index') }}" 
           class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            Lihat Daftar Buku
        </a>

    </div>
@endsection