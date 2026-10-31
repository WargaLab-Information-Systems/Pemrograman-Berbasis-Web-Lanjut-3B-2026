<div class="book-card">


    <h3>{{ $buku['judul'] }}</h3>

    <p>
        <strong>Penulis:</strong>
        {{ $buku['penulis'] }}
    </p>

    <p>
        <strong>Tahun Terbit:</strong>
        {{ $buku['tahun'] }}
    </p>

    <div class="book-extra">
        {{ $slot }}
    </div>

    <a href="{{ route('buku.detail', $buku['id']) }}" class="btn">
        Lihat Detail
    </a>

</div>



