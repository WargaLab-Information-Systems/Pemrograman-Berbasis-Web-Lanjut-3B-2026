@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Daftar Koleksi Buku</h2>
    <div class="flex flex-wrap justify-center gap-6">
        
        @foreach ($buku as $item)
            <x-book-card :buku="$item">
                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                    ✅ Tersedia
                </span>
            </x-book-card>
        @endforeach

    </div>
@endsection