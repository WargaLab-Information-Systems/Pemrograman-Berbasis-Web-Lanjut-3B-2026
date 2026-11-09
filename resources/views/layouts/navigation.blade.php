
<nav x-data="{ open: false }" class="header">
    <div class="container header-content">

        {{-- LOGO --}}
        <a href="{{ route('dashboard') }}" class="logo">
            <span class="logo-icon">📚</span>
            <span>PerpustakaanKu</span>
        </a>

        {{-- MENU DESKTOP --}}
        <div class="navbar hidden sm:flex">

            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            @can('lihat daftar buku')
                <a href="{{ route('buku.index') }}"
                   class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
                    Data Buku
                </a>
            @endcan

            @can('kelola data pengguna')
                <a href="{{ route('pengguna.index') }}"
                   class="{{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
                    Kelola Pengguna
                </a>
            @endcan

            @can('kelola peminjaman')
                <a href="{{ route('peminjaman.index') }}"
                   class="{{ request()->routeIs('peminjaman.index') ? 'active' : '' }}">
                    Peminjaman
                </a>
            @endcan

            {{-- RIWAYAT KHUSUS SISWA --}}
            @role('siswa')
                @can('lihat riwayat peminjaman sendiri')
                    <a href="{{ route('peminjaman.riwayat') }}"
                       class="{{ request()->routeIs('peminjaman.riwayat') ? 'active' : '' }}">
                        Riwayat
                    </a>
                @endcan
            @endrole

            @can('kelola data petugas')
                <a href="{{ route('petugas.index') }}"
                   class="{{ request()->routeIs('petugas.*') ? 'active' : '' }}">
                    Petugas Perpustakaan
                </a>
            @endcan

        </div>

        {{-- PROFIL DAN LOGOUT --}}
        <div class="hidden sm:flex items-center gap-4">
            @auth
                <a href="{{ route('profile.edit') }}" class="btn-primary">
                    Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn-primary">Register</a>
            @endauth
        </div>

        {{-- TOMBOL MOBILE --}}
        <button @click="open = !open"
                class="sm:hidden text-2xl"
                aria-label="Buka menu">
            ☰
        </button>
    </div>

    {{-- MENU MOBILE --}}
    <div x-show="open" x-transition class="sm:hidden p-4"
         style="background:white; border-top:1px solid var(--border)">

        <div class="flex flex-col gap-3">

            <a href="{{ route('dashboard') }}">Dashboard</a>

            @can('lihat daftar buku')
                <a href="{{ route('buku.index') }}">Data Buku</a>
            @endcan

            @can('kelola data pengguna')
                <a href="{{ route('pengguna.index') }}">Kelola Pengguna</a>
            @endcan

            @can('kelola peminjaman')
                <a href="{{ route('peminjaman.index') }}">Peminjaman</a>
            @endcan

            {{-- RIWAYAT KHUSUS SISWA --}}
            @role('siswa')
                @can('lihat riwayat peminjaman sendiri')
                    <a href="{{ route('peminjaman.riwayat') }}">Riwayat</a>
                @endcan
            @endrole

            @can('kelola data petugas')
                <a href="{{ route('petugas.index') }}">Petugas Perpustakaan</a>
            @endcan

            @auth
                <a href="{{ route('profile.edit') }}">Profil</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth

        </div>
    </div>
</nav>
