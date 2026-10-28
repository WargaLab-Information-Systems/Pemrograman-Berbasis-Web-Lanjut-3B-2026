<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title')</title>
</head>

<body>

    <div class="container-fluid bg-light bg-gradientnt p-3">
        <div class="d-flex justify-content-center align-items-center ">
            <h1 class="text-center">Perpustakaan - Ribuan Kata</h1>
        </div>
    </div>

    <nav class="sticky-top navbar navbar-expand-sm navbar-dark shadow-sm" style="background-color: #a82a2a">
        <div class="container d-flex justify-content-center">
            <ul class="navbar-nav fw-bold">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('buku.index') }}">Daftar Buku</a>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer text-white pb-5" style="background-color: #a82a2a" id="kontak">
        <div class="container">
            <div class="row">
                <h2 class="text-center"> Kontak Kami</h2>
                <div class="col-lg-4 mt-3 text-start">
                    <div class="pt-2">
                        <p class="fw-bold">Kecamatan Puri, Mojokerto</p>
                        <p class="mt-3"><strong>Alamat:</strong> <span> Jl. Jendral Sudirman, Puri, Kec. Puri,
                                Kabupaten
                                Mojokerto, Jawa Timur 61363</span></p>
                        <p class="mt-3"><strong>Telepon:</strong> <span>(0321)591004</span></p>
                        <p> <strong>Website:</strong> <a href="https://puri.mojokertokab.go.id/"
                                target="blank"><span>www.puri.mojokertokab.go.id</span></a> </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
