@extends('layouts.app')

@section('content')
    @if ($buku)
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-200">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Detail Buku</h2>
            
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/2">
                    <img src="{{ asset('images/' . $buku['gambar']) }}" alt="Cover Buku" class="w-full h-auto object-cover rounded-lg shadow-sm">
                </div>

                <div class="w-full md:w-1/2 flex flex-col justify-center space-y-4">
                    <p><span class="font-semibold text-gray-600">ID Buku:</span> <span class="text-gray-800">{{ $buku['id'] }}</span></p>
                    <p><span class="font-semibold text-gray-600">Judul:</span> <span class="text-lg text-gray-900 font-bold">{{ $buku['judul'] }}</span></p>
                    <p><span class="font-semibold text-gray-600">Penulis:</span> <span class="text-gray-800">{{ $buku['penulis'] }}</span></p>
                    <p><span class="font-semibold text-gray-600">Tahun Terbit:</span> <span class="text-gray-800">{{ $buku['tahun_terbit'] }}</span></p>
                    <p><span class="font-semibold text-gray-600">Kategori:</span> <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold mt-1">{{ $buku['kategori'] }}</span></p>
                </div>
            </div>

            <div class="mt-8 text-center md:text-left">
                <a href="{{ route('buku.index') }}" class="inline-block px-6 py-2 bg-grey-300 ">
                &larr; Kembali ke Daftar Buku
                </a>
            </div>
        </div>
    @else
        <div class="max-w-md mx-auto bg-red-50 p-8 rounded-lg shadow-md border border-red-200 text-center mt-10">
            <h2 class="text-2xl font-bold text-red-600 mb-4">Buku Tidak Ditemukan!</h2>
            <p class="text-gray-700 mb-6">Maaf, data buku dengan ID tersebut tidak tersedia di perpustakaan kami.</p>
            
            <a href="{{ route('buku.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-medium">
                Kembali ke Daftar Buku
            </a>
        </div>
    @endif

@endsection