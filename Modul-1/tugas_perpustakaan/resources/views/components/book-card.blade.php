@props(['buku'])

<div class="bg-white border border-gray-200 rounded-lg p-5 shadow-lg w-64 text-center transform transition hover:-translate-y-1 hover:shadow-xl flex flex-col justify-between">
    <div>
        <img src="{{ asset('images/' . $buku['gambar']) }}" alt="Cover Buku" class="w-full h-48 object-cover rounded-md mb-4">
        
        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $buku['judul'] }}</h3>
        <p class="text-sm text-gray-500 mb-2">Kategori: {{ $buku['kategori'] }}</p>
        <div class="mb-4">
            {{ $slot }}
        </div>
    </div>
    
    <a href="{{ url('/buku/' . $buku['id']) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition w-full">
        Lihat Detail
    </a>
</div>