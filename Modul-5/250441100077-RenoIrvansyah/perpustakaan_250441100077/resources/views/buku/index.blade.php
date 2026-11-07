@extends('layouts.perpus')

@section('title', 'Daftar Buku')

@section('content')

    <section id="sec-daftar-buku" class="mt-3">

        <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Daftar Buku</h2>
                <p class="mt-2 text-gray-500">
                    Kelola koleksi buku Perpustakaan Ribuan Kata.
                </p>
            </div>

            @can('kelola data buku')
                <div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h3 class="mb-6 text-xl font-bold text-gray-800">Tambah Buku</h3>

                    <form id="form-buku" class="space-y-5">
                        <input type="hidden" id="buku_id" name="buku_id">
                        <div>
                            <label for="kategori_id" class="mb-2 block text-sm font-semibold text-gray-700">
                                Kategori
                            </label>
                            <select id="kategori_id" name="kategori_id"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-red-700 focus:outline-none focus:ring-2 focus:ring-red-100">
                                <option value="">Pilih kategori</option>

                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="judul" class="mb-2 block text-sm font-semibold text-gray-700">
                                Judul Buku
                            </label>
                            <input type="text" id="judul" name="judul" maxlength="255"
                                placeholder="Masukkan judul buku"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-red-700 focus:outline-none focus:ring-2 focus:ring-red-100">
                        </div>

                        <div>
                            <label for="penulis" class="mb-2 block text-sm font-semibold text-gray-700">
                                Penulis
                            </label>
                            <input type="text" id="penulis" name="penulis" placeholder="Masukkan nama penulis"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-red-700 focus:outline-none focus:ring-2 focus:ring-red-100">
                        </div>

                        <div>
                            <label for="tahun_terbit" class="mb-2 block text-sm font-semibold text-gray-700">
                                Tahun Terbit
                            </label>
                            <input type="number" id="tahun_terbit" name="tahun_terbit" min="1000" max="9999"
                                placeholder="Contoh: 2024"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-red-700 focus:outline-none focus:ring-2 focus:ring-red-100">
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <button type="submit" id="tombol-simpan"
                                class="rounded-lg px-6 py-3 font-semibold text-white transition hover:opacity-90"
                                style="background-color: #a82a2a;">
                                Simpan Buku
                            </button>

                            <button type="reset"
                                class="rounded-lg border border-gray-300 px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-100">
                                Reset
                            </button>
                        </div>

                        <p id="pesan-form" class="text-sm" role="status" aria-live="polite"></p>
                    </form>
                </div>
            @endcan

        </section>

        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Judul Buku</th>
                        <th class="px-6 py-4">Penulis</th>
                        <th class="px-6 py-4">Tahun Terbit</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody id="daftar-buku" class="divide-y divide-gray-200">
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Memuat data buku...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex flex-col items-center justify-between gap-4 sm:flex-row">
            <p id="info-halaman" class="text-sm text-gray-500"></p>

            <div id="pagination" class="flex flex-wrap items-center justify-center gap-2">
            </div>
        </div>
    </section>

    <script>
        const formBuku = document.getElementById('form-buku');
        const pesanForm = document.getElementById('pesan-form');
        const tabelBuku = document.getElementById('daftar-buku');
        const pagination = document.getElementById('pagination');
        const infoHalaman = document.getElementById('info-halaman');

        const bolehKelolaBuku = @json(auth()->user()->can('kelola data buku'));

        let halamanAktif = 1;

        formBuku.addEventListener('submit', async function(event) {
            event.preventDefault();

            const bukuId = document.getElementById('buku_id').value;
            const sedangEdit = bukuId !== '';

            pesanForm.textContent = sedangEdit ?
                'Memperbarui data buku...' :
                'Menyimpan data buku...';

            pesanForm.className = 'text-sm text-gray-500';

            const dataBuku = {
                kategori_id: Number(formBuku.kategori_id.value),
                judul: formBuku.judul.value.trim(),
                penulis: formBuku.penulis.value.trim(),
                tahun_terbit: Number(formBuku.tahun_terbit.value)
            };

            try {
                const response = await fetch(
                    sedangEdit ? `/api/buku/${bukuId}` : '/api/buku', {
                        method: sedangEdit ? 'PUT' : 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(dataBuku)
                    }
                );

                const hasil = await response.json();

                if (!response.ok) {
                    const detailError = hasil.errors ?
                        Object.values(hasil.errors).flat().join(' ') :
                        hasil.message;

                    throw new Error(detailError || 'Gagal menyimpan data buku.');
                }

                pesanForm.textContent = hasil.message ||
                    (sedangEdit ?
                        'Buku berhasil diperbarui.' :
                        'Buku berhasil ditambahkan.');

                pesanForm.className = 'text-sm font-medium text-green-600';

                formBuku.reset();

                await tampilkanBuku(halamanAktif);

            } catch (error) {
                pesanForm.textContent = error.message ||
                    'Terjadi kesalahan saat menyimpan data buku.';

                pesanForm.className = 'text-sm font-medium text-red-600';
            }
        });

        // Reset form
        formBuku.addEventListener('reset', function() {
            document.getElementById('buku_id').value = '';

            document.getElementById('tombol-simpan').textContent = 'Simpan Buku';

            pesanForm.textContent = '';
            pesanForm.className = 'text-sm';
        });


        async function tampilkanBuku(halaman = 1) {
            try {
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

                // Kembali ke halaman terakhir jika halaman sudah tidak tersedia
                if (meta.last_page > 0 && halaman > meta.last_page) {
                    await tampilkanBuku(meta.last_page);
                    return;
                }

                halamanAktif = meta.current_page;

                tabelBuku.innerHTML = '';

                if (!bukus || bukus.length === 0) {
                    tabelBuku.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        Belum ada data buku.
                    </td>
                </tr>
            `;

                    pagination.innerHTML = '';
                    infoHalaman.textContent = '';
                    return;
                }

                // Menampilkan data buku dalam tabel
                bukus.forEach((buku, index) => {
                    tabelBuku.innerHTML += `
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-6 py-4">${meta.from + index}</td>
                    <td class="px-6 py-4">${buku.kategori ?? '-'}</td>
                    <td class="px-6 py-4">${buku.judul}</td>
                    <td class="px-6 py-4">${buku.penulis}</td>
                    <td class="px-6 py-4">${buku.tahun_terbit}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2">

                            <button
                                onclick="detailBuku(${buku.id})"
                                class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700">
                                Detail
                            </button>

                            ${bolehKelolaBuku ? `
                                    <button
                                        type="button"
                                        onclick="editBuku(${buku.id})"
                                        class="rounded-lg bg-yellow-500 px-4 py-2 font-medium text-white transition hover:bg-yellow-600">
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        onclick="hapusBuku(${buku.id})"
                                        class="rounded-lg bg-red-600 px-4 py-2 font-medium text-white hover:bg-red-700">
                                        Hapus
                                    </button>
                                ` : ''}

                        </div>
                    </td>
                </tr>
            `;
                });

                // Tampilkan pagination
                tampilkanPagination(meta);

                // Informasi jumlah data
                infoHalaman.textContent =
                    `Menampilkan ${meta.from}–${meta.to} dari ${meta.total} buku`;

            } catch (error) {
                console.error(error);

                tabelBuku.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-red-600">
                    Gagal memuat data buku. Silakan coba lagi.
                </td>
            </tr>
        `;

                pagination.innerHTML = '';
                infoHalaman.textContent = '';
            }
        }

        function tampilkanPagination(meta) {
            const halamanSekarang = meta.current_page;
            const totalHalaman = meta.last_page;

            pagination.innerHTML = '';

            if (totalHalaman <= 1) {
                return;
            }

            // Tombol Sebelumnya
            pagination.innerHTML += `
        <button
            type="button"
            onclick="tampilkanBuku(${halamanSekarang - 1})"
            ${halamanSekarang === 1 ? 'disabled' : ''}
            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium
            ${halamanSekarang === 1
                ? 'cursor-not-allowed bg-gray-100 text-gray-400'
                : 'bg-white text-gray-700 hover:bg-gray-100'}">
            Sebelumnya
        </button>
    `;

            // Nomor halaman
            for (let i = 1; i <= totalHalaman; i++) {
                pagination.innerHTML += `
            <button
                type="button"
                onclick="tampilkanBuku(${i})"
                class="rounded-lg border px-4 py-2 text-sm font-medium transition
                ${i === halamanSekarang
                    ? 'border-[#a82a2a] bg-[#a82a2a] text-white'
                    : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100'}">
                ${i}
            </button>
        `;
            }

            // Tombol Selanjutnya
            pagination.innerHTML += `
        <button
            type="button"
            onclick="tampilkanBuku(${halamanSekarang + 1})"
            ${halamanSekarang === totalHalaman ? 'disabled' : ''}
            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium
            ${halamanSekarang === totalHalaman
                ? 'cursor-not-allowed bg-gray-100 text-gray-400'
                : 'bg-white text-gray-700 hover:bg-gray-100'}">
            Selanjutnya
        </button>
    `;
        }


        function detailBuku(id) {
            window.location.href = `/buku/${id}`;
        }

        async function editBuku(id) {
            try {
                const response = await fetch(`/api/buku/${id}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const hasil = await response.json();

                if (!response.ok) {
                    throw new Error(hasil.message || 'Gagal mengambil data buku.');
                }

                const buku = hasil.data;

                document.getElementById('buku_id').value = buku.id;
                document.getElementById('kategori_id').value = buku.kategori_id;
                document.getElementById('judul').value = buku.judul;
                document.getElementById('penulis').value = buku.penulis;
                document.getElementById('tahun_terbit').value = buku.tahun_terbit;

                document.getElementById('tombol-simpan').textContent = 'Update Buku';

                pesanForm.textContent = 'Mode edit: silakan ubah data buku.';
                pesanForm.className = 'text-sm text-yellow-600';

                formBuku.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

            } catch (error) {
                alert(error.message || 'Terjadi kesalahan saat mengambil data buku.');
            }
        }


        async function hapusBuku(id) {
            const konfirmasi = confirm(
                `Apakah kamu yakin ingin menghapus buku dengan ID ${id}?`
            );

            if (!konfirmasi) {
                return;
            }

            try {
                const response = await fetch(`/api/buku/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const hasil = await response.json();

                if (!response.ok) {
                    throw new Error(hasil.message || 'Buku gagal dihapus.');
                }

                if (document.getElementById('buku_id').value === String(id)) {
                    formBuku.reset();
                }

                pesanForm.textContent =
                    hasil.message || 'Buku berhasil dihapus.';

                pesanForm.className = 'text-sm font-medium text-green-600';

                await tampilkanBuku(halamanAktif);

            } catch (error) {
                console.error('Error hapus buku:', error);

                pesanForm.textContent =
                    error.message || 'Terjadi kesalahan saat menghapus buku.';

                pesanForm.className = 'text-sm font-medium text-red-600';
            }
        }

        tampilkanBuku();
    </script>

@endsection
