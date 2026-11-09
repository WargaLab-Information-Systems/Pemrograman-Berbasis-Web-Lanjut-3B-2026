
@extends('layouts.app')

@section('title', 'Daftar Buku - PerpustakaanKu')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/buku.css') }}">
@endpush

@section('content')

@php
    $bolehKelolaBuku = auth()->user()->can('kelola data buku');
@endphp

<section class="page-header">
    <div class="container">
        <span class="badge">📚 Koleksi Perpustakaan</span>
        <h1>Daftar Buku</h1>
        <p>
            Lihat koleksi buku PerpustakaanKu.
        </p>
    </div>
</section>

<section class="book-section">
    <div class="container">

        {{-- FORM TAMBAH DAN EDIT KHUSUS ADMIN --}}
        @if($bolehKelolaBuku)
            <div class="form-card">

                <div class="form-header">
                    <div>
                        <span class="form-label">MANAJEMEN BUKU</span>
                        <h2 id="judulForm">Tambah Buku</h2>
                        <p>Masukkan informasi buku yang ingin disimpan.</p>
                    </div>

                    <div class="form-icon">📖</div>
                </div>

                <div id="pesan"></div>

                <form id="formBuku">
                    @csrf

                    <input type="hidden" id="buku_id">

                    <div class="form-grid">

                        <div class="input-group">
                            <label for="kategori_id">Kategori</label>
                            <select id="kategori_id" required>
                                <option value="" disabled selected>
                                    Pilih kategori buku
                                </option>
                            </select>
                            <small>Pilih kategori buku.</small>
                        </div>

                        <div class="input-group">
                            <label for="judul">Judul Buku</label>
                            <input
                                type="text"
                                id="judul"
                                placeholder="Masukkan judul buku"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label for="penulis">Penulis</label>
                            <input
                                type="text"
                                id="penulis"
                                placeholder="Masukkan nama penulis"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label for="tahun_terbit">Tahun Terbit</label>
                            <input
                                type="number"
                                id="tahun_terbit"
                                placeholder="Contoh: 2026"
                                required
                            >
                        </div>

                    </div>

                    <div class="form-actions">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="btnSimpan"
                        >
                            <span>💾</span>
                            Simpan Buku
                        </button>

                        <button
                            type="button"
                            class="btn btn-secondary"
                            id="btnBatal"
                            style="display: none;"
                        >
                            Batal
                        </button>
                    </div>
                </form>

            </div>
        @endif

        {{-- DAFTAR BUKU --}}
        <div class="table-card">

            <div class="table-header">
                <div>
                    <span class="form-label">KOLEKSI</span>
                    <h2>Daftar Buku</h2>
                    <p>Data buku yang tersedia di perpustakaan.</p>
                </div>

                <div class="book-count">📚</div>
            </div>

            <div id="loading" class="loading">
                <div class="spinner"></div>
                <span>Memuat data buku...</span>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Tahun</th>

                            @if($bolehKelolaBuku)
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody id="tabelBuku"></tbody>
                </table>
            </div>

        </div>

    </div>
</section>

<script>
const bolehKelolaBuku = @json($bolehKelolaBuku);

const tabelBuku = document.getElementById('tabelBuku');
const loading = document.getElementById('loading');

const form = document.getElementById('formBuku');
const pesan = document.getElementById('pesan');
const btnBatal = document.getElementById('btnBatal');
const btnSimpan = document.getElementById('btnSimpan');
const judulForm = document.getElementById('judulForm');


// ========================================
// GET DATA BUKU
// ========================================

async function ambilBuku() {
    loading.style.display = 'flex';

    try {
        const response = await fetch('/api/buku', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Gagal mengambil data buku.');
        }

        const result = await response.json();

        tampilkanBuku(result.data);

    } catch (error) {
        const colspan = bolehKelolaBuku ? 6 : 5;

        tabelBuku.innerHTML = `
            <tr>
                <td colspan="${colspan}">
                    <div class="error-state">
                        ❌ ${error.message}
                    </div>
                </td>
            </tr>
        `;

    } finally {
        loading.style.display = 'none';
    }
}


// ========================================
// TAMPILKAN DATA BUKU
// ========================================

function tampilkanBuku(data) {
    tabelBuku.innerHTML = '';

    if (!data || data.length === 0) {
        const colspan = bolehKelolaBuku ? 6 : 5;

        tabelBuku.innerHTML = `
            <tr>
                <td colspan="${colspan}">
                    <div class="empty-state">
                        <div class="empty-icon">📚</div>
                        <h3>Belum Ada Buku</h3>
                        <p>Belum ada koleksi buku yang tersedia.</p>
                    </div>
                </td>
            </tr>
        `;

        return;
    }

    data.forEach((buku, index) => {

        let kolomAksi = '';

        // Tombol Edit dan Hapus hanya untuk Admin
        if (bolehKelolaBuku) {
            kolomAksi = `
                <td>
                    <div class="action-buttons">

                        <button
                            class="btn-action edit"
                            onclick="ubahBuku(${buku.id})"
                            title="Ubah buku"
                        >
                            ✏️
                        </button>

                        <button
                            class="btn-action delete"
                            onclick="hapusBuku(${buku.id})"
                            title="Hapus buku"
                        >
                            🗑️
                        </button>

                    </div>
                </td>
            `;
        }

        tabelBuku.innerHTML += `
            <tr>
                <td class="number">${index + 1}</td>

                <td>
                    <span class="category">
                        ${buku.kategori ?? '-'}
                    </span>
                </td>

                <td>
                    <div class="book-title">
                        <span class="book-small-icon">📖</span>
                        <strong>${buku.judul}</strong>
                    </div>
                </td>

                <td>
                    <span class="author">${buku.penulis}</span>
                </td>

                <td>
                    <span class="year">${buku.tahun_terbit}</span>
                </td>

                ${kolomAksi}
            </tr>
        `;
    });
}


// ========================================
// FITUR CRUD KHUSUS ADMIN
// ========================================

if (bolehKelolaBuku) {

    // ========================================
    // TAMBAH DAN UPDATE BUKU
    // ========================================

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = document.getElementById('buku_id').value;

        const data = {
            kategori_id: document.getElementById('kategori_id').value,
            judul: document.getElementById('judul').value,
            penulis: document.getElementById('penulis').value,
            tahun_terbit: document.getElementById('tahun_terbit').value
        };

        try {
            const url = id
                ? `/api/buku/${id}`
                : '/api/buku';

            const method = id ? 'PUT' : 'POST';

            btnSimpan.disabled = true;
            btnSimpan.innerHTML = '⏳ Menyimpan...';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (!response.ok) {
                let pesanError = result.message || 'Gagal menyimpan data.';

                if (result.errors) {
                    pesanError = Object.values(result.errors)
                        .flat()
                        .join('<br>');
                }

                throw new Error(pesanError);
            }

            tampilkanPesan(
                result.message || 'Data buku berhasil disimpan.',
                'success'
            );

            form.reset();

            document.getElementById('buku_id').value = '';

            btnBatal.style.display = 'none';
            judulForm.innerText = 'Tambah Buku';

            await ambilBuku();

        } catch (error) {
            tampilkanPesan(error.message, 'error');

        } finally {
            btnSimpan.disabled = false;
            btnSimpan.innerHTML = '<span>💾</span> Simpan Buku';
        }
    });


    // ========================================
    // UBAH BUKU
    // ========================================

    async function ubahBuku(id) {
        try {
            const response = await fetch(`/api/buku/${id}`, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil detail buku.');
            }

            const result = await response.json();

            const buku = result.data ?? result;

            document.getElementById('buku_id').value = buku.id;
            document.getElementById('kategori_id').value = buku.kategori_id;
            document.getElementById('judul').value = buku.judul;
            document.getElementById('penulis').value = buku.penulis;
            document.getElementById('tahun_terbit').value = buku.tahun_terbit;

            judulForm.innerText = 'Ubah Data Buku';

            btnSimpan.innerHTML = '<span>✏️</span> Simpan Perubahan';

            btnBatal.style.display = 'inline-flex';

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

        } catch (error) {
            tampilkanPesan(error.message, 'error');
        }
    }


    // ========================================
    // BATAL EDIT
    // ========================================

    btnBatal.addEventListener('click', function() {
        form.reset();

        document.getElementById('buku_id').value = '';

        btnBatal.style.display = 'none';

        judulForm.innerText = 'Tambah Buku';

        btnSimpan.innerHTML = '<span>💾</span> Simpan Buku';

        pesan.innerHTML = '';
    });


    // ========================================
    // HAPUS BUKU
    // ========================================

    async function hapusBuku(id) {
        const yakin = confirm(
            'Apakah kamu yakin ingin menghapus buku ini?'
        );

        if (!yakin) {
            return;
        }

        try {
            const response = await fetch(`/api/buku/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
                }
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(
                    result.message || 'Gagal menghapus buku.'
                );
            }

            tampilkanPesan(
                result.message || 'Buku berhasil dihapus.',
                'success'
            );

            await ambilBuku();

        } catch (error) {
            tampilkanPesan(error.message, 'error');
        }
    }


    // ========================================
    // AMBIL KATEGORI
    // ========================================

    async function ambilKategori() {
        try {
            const response = await fetch('/api/kategori', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data kategori.');
            }

            const result = await response.json();

            const select = document.getElementById('kategori_id');

            select.innerHTML = `
                <option value="">Pilih kategori</option>
            `;

            result.forEach(kategori => {
                select.innerHTML += `
                    <option value="${kategori.id}">
                        ${kategori.nama}
                    </option>
                `;
            });

        } catch (error) {
            tampilkanPesan(error.message, 'error');
        }
    }

    ambilKategori();
}


// ========================================
// PESAN
// ========================================

function tampilkanPesan(text, type) {
    if (!pesan) return;

    pesan.innerHTML = `
        <div class="alert ${type}">
            <span>
                ${type === 'success' ? '✓' : '⚠'}
            </span>
            <div>${text}</div>
        </div>
    `;
}


// ========================================
// JALANKAN SAAT HALAMAN DIBUKA
// ========================================

ambilBuku();

</script>

@endsection
