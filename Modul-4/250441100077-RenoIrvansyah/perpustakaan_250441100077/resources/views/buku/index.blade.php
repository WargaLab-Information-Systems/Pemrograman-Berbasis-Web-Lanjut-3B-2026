@extends('layouts.app')

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

            <div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="mb-6 text-xl font-bold text-gray-800">Tambah Buku</h3>

                <form id="form-buku" class="space-y-5">
                    <input type="hidden" id="buku_id" name="buku_id">
                    <div>
                        <label for="kategori_id" class="mb-2 block text-sm font-semibold text-gray-700">
                            Kategori
                        </label>
                        {{-- <select id="kategori_id" name="kategori_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-red-700 focus:outline-none focus:ring-2 focus:ring-red-100">
                            <option value="">Pilih kategori</option>
                            <option value="1">Komik</option>
                            <option value="2">Jurnal</option>
                            <option value="3">Biografi</option>
                        </select> --}}
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
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Memuat data buku...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <script>
        const formBuku = document.getElementById('form-buku');
        const pesanForm = document.getElementById('pesan-form');
        const tabelBuku = document.getElementById('daftar-buku');

        // ubah dari sebelumnya
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

                // formBuku.reset();
                // document.getElementById('buku_id').value = '';
                // document.getElementById('tombol-simpan').textContent = 'Simpan Buku';

                await tampilkanBuku();

            } catch (error) {
                pesanForm.textContent = error.message ||
                    'Terjadi kesalahan saat menyimpan data buku.';

                pesanForm.className = 'text-sm font-medium text-red-600';
            }
        });

        formBuku.addEventListener('reset', function() {
            document.getElementById('buku_id').value = '';

            document.getElementById('tombol-simpan').textContent = 'Simpan Buku';

            pesanForm.textContent = '';
            pesanForm.className = 'text-sm';
        });

        async function tampilkanBuku() {
            const tabelBuku = document.getElementById('daftar-buku');

            try {
                const response = await fetch('/api/buku');

                if (!response.ok) {
                    throw new Error('Gagal mengambil data buku.');
                }

                const hasil = await response.json();
                const bukus = hasil.data;

                tabelBuku.innerHTML = '';

                if (bukus.length === 0) {
                    tabelBuku.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada data buku.
                        </td>
                    </tr>
                `;
                    return;
                }

                bukus.forEach((buku, index) => {
                    tabelBuku.innerHTML += `
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4">${index + 1}</td>
                            <td class="px-6 py-4">${buku.kategori ?? '-'}</td>
                            <td class="px-6 py-4">${buku.judul}</td>
                            <td class="px-6 py-4">${buku.penulis}</td>
                            <td class="px-6 py-4">${buku.tahun_terbit}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        onclick="detailBuku(${buku.id})"
                                        class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700"
                                    >
                                        Detail
                                    </button>
                                    <button
                                        type="button"
                                        onclick="editBuku(${buku.id})"
                                        class="rounded-lg bg-yellow-500 px-4 py-2 font-medium text-white transition hover:bg-yellow-600"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        onclick="hapusBuku(${buku.id})"
                                        class="rounded-lg bg-red-600 px-4 py-2 font-medium text-white hover:bg-red-700"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });

            } catch (error) {
                console.error(error);

                tabelBuku.innerHTML = `
                <tr>
                    <t colspan="5" class="text-center text-danger">
                        Gagal memuat data buku. Silakan coba lagi.
                    </t d>
                </tr>
            `;
            }
        }

        tampilkanBuku();

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
                document.getElementById('pesan-form').textContent =
                    'Mode edit: silakan ubah data buku.';

                document.getElementById('pesan-form').className =
                    'text-sm text-yellow-600';

                document.getElementById('form-buku').scrollIntoView({
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
                    throw new Error(
                        hasil.message || 'Buku gagal dihapus.'
                    );
                }

                if (document.getElementById('buku_id').value === String(id)) {
                    formBuku.reset();
                }

                pesanForm.textContent =
                    hasil.message || 'Buku berhasil dihapus.';
                pesanForm.className = 'text-sm font-medium text-green-600';

                await tampilkanBuku();

            } catch (error) {
                console.error('Error hapus buku:', error);

                pesanForm.textContent =
                    error.message || 'Terjadi kesalahan saat menghapus buku.';
                pesanForm.className = 'text-sm font-medium text-red-600';
            }
        }
    </script>

@endsection
