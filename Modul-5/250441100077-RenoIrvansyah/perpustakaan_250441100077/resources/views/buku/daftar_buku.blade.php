@extends('layouts.perpus')

@section('title', 'Daftar Buku')

@section('content')

    <section class="mx-auto mt-3 max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Header halaman --}}
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Daftar Buku</h2>
            <p class="mt-2 text-gray-500">
                Temukan dan lihat koleksi buku Perpustakaan Ribuan Kata.
            </p>
        </div>

        {{-- Daftar Card Buku --}}
        <div id="daftar-buku" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

            <div class="col-span-full py-12 text-center text-gray-500">
                Memuat data buku...
            </div>

        </div>

        {{-- Pagination --}}
        <div id="pagination" class="mt-10 flex flex-wrap items-center justify-center gap-2">
        </div>

    </section>

    <script>
        const daftarBuku = document.getElementById('daftar-buku');
        const pagination = document.getElementById('pagination');

        async function tampilkanBuku(halaman = 1) {
            try {
                daftarBuku.innerHTML = `
                    <div class="col-span-full py-12 text-center text-gray-500">
                        Memuat data buku...
                    </div>
                `;

                const response = await fetch(`/api/buku?page=${halaman}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil data buku.');
                }

                const hasil = await response.json();
                const bukus = hasil.data;
                const meta = hasil.meta;

                daftarBuku.innerHTML = '';

                if (!bukus || bukus.length === 0) {
                    daftarBuku.innerHTML = `
                        <div class="col-span-full rounded-xl border border-gray-200 bg-white py-12 text-center text-gray-500">
                            Belum ada koleksi buku.
                        </div>
                    `;

                    pagination.innerHTML = '';
                    return;
                }

                // Menampilkan card buku
                bukus.forEach((buku) => {
                    daftarBuku.innerHTML += `
                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                            <div class="p-6">

                                <div class="mb-4 flex items-start justify-between gap-3">
                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-[#a82a2a]">
                                        ${buku.kategori ?? 'Tanpa Kategori'}
                                    </span>

                                    <span class="text-sm text-gray-400">
                                        ${buku.tahun_terbit ?? '-'}
                                    </span>
                                </div>

                                <h3 class="mb-2 text-xl font-bold text-gray-800">
                                    ${buku.judul ?? 'Judul Tidak Tersedia'}
                                </h3>

                                <p class="mb-6 text-sm text-gray-500">
                                    Penulis: ${buku.penulis ?? '-'}
                                </p>

                                <div class="border-t border-gray-100 pt-4">
                                    <button
                                        type="button"
                                        onclick="detailBuku(${Number(buku.id)})"
                                        class="w-full rounded-lg bg-[#a82a2a] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#872020]">
                                        Lihat Detail
                                    </button>
                                </div>

                            </div>
                        </div>
                    `;
                });

                // Menampilkan navigasi halaman
                tampilkanPagination(meta);

            } catch (error) {
                console.error(error);

                daftarBuku.innerHTML = `
                    <div class="col-span-full rounded-xl border border-red-200 bg-red-50 py-12 text-center text-red-600">
                        Gagal memuat data buku. Silakan coba lagi.
                    </div>
                `;

                pagination.innerHTML = '';
            }
        }

        function tampilkanPagination(meta) {
            const halamanAktif = meta.current_page;
            const totalHalaman = meta.last_page;

            pagination.innerHTML = '';

            // Tombol Sebelumnya
            pagination.innerHTML += `
                <button
                    onclick="tampilkanBuku(${halamanAktif - 1})"
                    ${halamanAktif === 1 ? 'disabled' : ''}
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium
                    ${halamanAktif === 1
                        ? 'cursor-not-allowed bg-gray-100 text-gray-400'
                        : 'bg-white text-gray-700 hover:bg-gray-100'}">
                    Sebelumnya
                </button>
            `;

            // Nomor halaman
            for (let i = 1; i <= totalHalaman; i++) {
                pagination.innerHTML += `
                    <button
                        onclick="tampilkanBuku(${i})"
                        class="rounded-lg border px-4 py-2 text-sm font-medium transition
                        ${i === halamanAktif
                            ? 'border-[#a82a2a] bg-[#a82a2a] text-white'
                            : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100'}">
                        ${i}
                    </button>
                `;
            }

            // Tombol Selanjutnya
            pagination.innerHTML += `
                <button
                    onclick="tampilkanBuku(${halamanAktif + 1})"
                    ${halamanAktif === totalHalaman ? 'disabled' : ''}
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium
                    ${halamanAktif === totalHalaman
                        ? 'cursor-not-allowed bg-gray-100 text-gray-400'
                        : 'bg-white text-gray-700 hover:bg-gray-100'}">
                    Selanjutnya
                </button>
            `;
        }

        function detailBuku(id) {
            window.location.href = `/buku/${id}`;
        }

        tampilkanBuku();
    </script>

@endsection
