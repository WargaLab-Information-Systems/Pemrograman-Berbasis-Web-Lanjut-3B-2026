@props([
    'judul',
    'penulis',
    'tahun',
    'id'
])

<div class="book-card">

    <div class="book-cover">
        <span>📖</span>
    </div>

    <div class="book-info">

        <h3>{{ $judul }}</h3>

        <p class="author">
            ✍️ {{ $penulis }}
        </p>

        <p class="year">
            📅 {{ $tahun }}
        </p>

        <div class="card-footer">
            {{ $slot }}

            <a href="{{ route('buku.show', $id) }}" class="btn-detail">
                Detail →
            </a>
        </div>

    </div>

</div>