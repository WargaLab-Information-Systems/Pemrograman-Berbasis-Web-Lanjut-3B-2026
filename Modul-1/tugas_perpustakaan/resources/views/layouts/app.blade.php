<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 font-sans flex flex-col min-h-screen">

    <header class="bg-white shadow-sm py-6 text-center">
        <h1 class="text-3xl font-bold text-blue-600">Perpustakaan Nafis</h1>
    </header>

    <nav class="bg-blue-600 p-4 text-center space-x-6">
        <a href="{{ route('home') }}" class="text-white hover:text-blue-200 font-semibold transition">Beranda</a>
        <a href="{{ route('buku.index') }}" class="text-white hover:text-blue-200 font-semibold transition">Daftar Buku</a>
    </nav>

    <main class="container mx-auto p-6 flex-grow">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white text-center p-4 mt-8">
        <p>&copy; 2026 Aplikasi Perpustakaan. All rights reserved.</p>
    </footer>

</body>
</html>