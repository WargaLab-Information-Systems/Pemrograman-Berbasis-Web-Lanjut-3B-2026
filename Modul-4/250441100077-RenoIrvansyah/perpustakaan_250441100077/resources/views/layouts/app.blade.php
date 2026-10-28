<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title')</title>
</head>

<body class="min-h-screen flex flex-col bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="bg-gray-100 bg-gradient-to-b from-white to-gray-100 px-4 py-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-center">
            <h1 class="text-center text-2xl font-bold tracking-wide text-gray-800 sm:text-3xl">
                Perpustakaan - Ribuan Kata
            </h1>
        </div>
    </header>

    <nav class="sticky top-0 z-50 shadow-md" style="background-color: #a82a2a;">
        <div class="mx-auto flex max-w-7xl items-center justify-center px-4">
            <ul class="flex items-center justify-center gap-2 font-bold sm:gap-6">
                <li>
                    <a href="{{ route('home') }}"
                        class="inline-block px-4 py-4 text-white transition-colors duration-200 hover:bg-white/10"
                        aria-current="{{ request()->routeIs('home') ? 'page' : 'false' }}">
                        Beranda
                    </a>
                </li>

                <li>
                    <a href="{{ route('buku.index') }}"
                        class="inline-block px-4 py-4 text-white transition-colors duration-200 hover:bg-white/10"
                        aria-current="{{ request()->routeIs('buku.index') ? 'page' : 'false' }}">
                        Daftar Buku
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="w-full flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="kontak" class="mt-12 pb-10 pt-8 text-white" style="background-color: #a82a2a;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <h2 class="mb-6 text-center text-2xl font-bold">
                Kontak Kami
            </h2>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="text-left">
                    <h3 class="mb-4 text-lg font-bold">
                        Kecamatan Puri, Mojokerto
                    </h3>

                    <div class="space-y-3 text-sm leading-relaxed sm:text-base">
                        <p>
                            <strong>Alamat:</strong>
                            Jl. Jendral Sudirman, Puri, Kec. Puri,
                            Kabupaten Mojokerto, Jawa Timur 61363
                        </p>

                        <p>
                            <strong>Telepon:</strong>
                            (0321)591004
                        </p>

                        <p>
                            <strong>Website:</strong>
                            <a href="https://puri.mojokertokab.go.id/" target="_blank" rel="noopener noreferrer"
                                class="underline decoration-white/60 underline-offset-4 transition hover:text-gray-200">
                                www.puri.mojokertokab.go.id
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t border-white/20 pt-4 text-center text-sm text-white/80">
                &copy; {{ date('Y') }} Perpustakaan - Ribuan Kata
            </div>

        </div>
    </footer>

</body>

</html>
