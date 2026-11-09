<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PerpustakaanKu')</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header Website -->
    <header class="bg-dark text-white py-4 shadow-sm">
        <div class="container">
            <h1 class="fw-bold mb-1">PerpustakaanKu</h1>
            <p class="mb-0 text-white-50">Temukan buku favoritmu dan jelajahi dunia pengetahuan.</p>
        </div>
    </header>

    <!-- Navigasi / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ url('/') }}">Beranda</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('buku.index') }}">Daftar Buku</a>
                    </li>
                </ul>

                <!-- Tombol Login / Dashboard -->
                <div class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm px-3">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-light btn-sm px-4 fw-semibold text-dark">Log In</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="container my-5 flex-fill">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto shadow-sm">
        <div class="container">
            <p class="mb-0 text-white-50 small">&copy; {{ date('Y') }} PerpustakaanKu. Semua hak dilindungi.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>