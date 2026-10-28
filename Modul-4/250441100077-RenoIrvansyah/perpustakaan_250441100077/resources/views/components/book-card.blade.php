<div>
    <div class="card">
        <img src="{{ asset('images/buku/' . $poster) }}" class="card-img-top img-fluid object-fit-contain mt-3"
            style="height: 200px;" alt="">
        <div class="card-body">
            <h3 class="text-center">{{ $judul }}</h3>
            <hr class="border border-dark border-3 opacity-75">
            <p class="card-text">
                <strong>Penulis:</strong> {{ $penulis }}
            </p>
            <hr class="border border-dark opacity-75">
            <p class="card-text">
                <strong>Tahun Terbit:</strong> {{ $tahun }}
            </p>
            <p class="card-text">
                <strong>Kategori:</strong> {{ $kategori }}
            </p>
            <a href="{{ route('buku.detail', $id) }}" class="btn btn-secondary">Lihat Detail</a>

            {{ $slot }}
        </div>
    </div>
</div>
