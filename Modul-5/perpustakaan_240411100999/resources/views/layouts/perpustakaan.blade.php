<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'PerpustakaanKu')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1>PerpustakaanKu</h1>
            <p>Temukan buku favoritmu dan jelajahi dunia pengetahuan.</p>
        </div>
    </header>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container nav-content">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('buku.index') }}">Daftar Buku</a>
        </div>
    </nav>

    <!-- Konten -->
    <main class="container content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} PerpustakaanKu. Semua hak dilindungi.</p>
        </div>
    </footer>

</body>
</html>