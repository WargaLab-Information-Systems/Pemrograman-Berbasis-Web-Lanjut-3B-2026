<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Perpustakaan')</title>

    @vite(['resources/css/app.css'])
</head>

<body>

    <header class="header">
        <div class="container header-content">
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-icon">📚</span>
                <span>PerpustakaanKu</span>
            </a>

            <nav class="navbar">
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    Beranda
                </a>

                <a href="{{ route('web.buku.index') }}"
                   class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
                    Daftar Buku
                </a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>© {{ date('Y') }} PerpustakaanKu</p>
            <p>Tempat membaca, belajar, dan menemukan inspirasi.</p>
        </div>
    </footer>

</body>
</html>

    














