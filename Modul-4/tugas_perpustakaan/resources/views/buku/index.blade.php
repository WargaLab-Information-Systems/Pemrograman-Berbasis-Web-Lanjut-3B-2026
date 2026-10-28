@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    
    <!-- Header Halaman + Tombol Buka Form -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-700">Daftar Koleksi Buku</h2>
        <button onclick="bukaFormTambah()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">
            + Tambah Buku Baru
        </button>
    </div>

    <!-- Container Form (Tambah/Edit) -->
    <div id="containerForm" class="hidden mb-8 p-4 bg-gray-50 border border-gray-200 rounded-lg">
        <h3 id="formTitle" class="text-lg font-bold mb-4 text-gray-700">Formulir Tambah Buku</h3>
        
        <!-- Kotak Alert Error UI (Soal 5) -->
        <div id="errorMessage" class="hidden mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm"></div>

        <form id="formBuku" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" id="buku_id">

            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori Buku</label>
                <select id="kategori_id" class="w-full border p-2 rounded bg-white">
                    <option value="">-- Pilih Kategori --</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Judul Buku</label>
                <input type="text" id="judul" class="w-full border p-2 rounded" placeholder="Judul Buku">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Penulis</label>
                <input type="text" id="penulis" class="w-full border p-2 rounded" placeholder="Nama Penulis">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                <input type="number" id="tahun" class="w-full border p-2 rounded" placeholder="2025">
            </div>
            
            <div class="md:col-span-2 flex gap-2">
                <button type="submit" id="btnSubmit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-semibold">
                    Simpan Buku
                </button>
                <button type="button" onclick="tutupForm()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Data Buku -->
    <table class="w-full border-collapse border border-gray-200" id="tabelBuku">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Kategori</th>
                <th class="border p-2">Judul</th>
                <th class="border p-2">Penulis</th>
                <th class="border p-2">Tahun Terbit</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data dimasukkan via Fetch API -->
        </tbody>
    </table>
</div>

<script>
function sembunyikanError() {
    const errorBox = document.getElementById('errorMessage');
    errorBox.classList.add('hidden');
    errorBox.innerHTML = '';
}

function tampilkanError(pesan) {
    const errorBox = document.getElementById('errorMessage');
    errorBox.innerHTML = pesan;
    errorBox.classList.remove('hidden');
}

function bukaFormTambah() {
    sembunyikanError();
    document.getElementById('buku_id').value = '';
    document.getElementById('formBuku').reset();
    document.getElementById('formTitle').innerText = 'Formulir Tambah Buku';
    document.getElementById('btnSubmit').innerText = 'Simpan Buku';
    document.getElementById('containerForm').classList.remove('hidden');
}

function tutupForm() {
    sembunyikanError();
    document.getElementById('formBuku').reset();
    document.getElementById('buku_id').value = '';
    document.getElementById('containerForm').classList.add('hidden');
}

// 1. Ambil Data Kategori
async function loadKategori() {
    try {
        const response = await fetch('/api/kategori');
        if (!response.ok) return;

        const result = await response.json();
        const select = document.getElementById('kategori_id');
        const categories = Array.isArray(result) ? result : (result.data || []);
        
        select.innerHTML = '<option value="">-- Pilih Kategori --</option>';
        categories.forEach(kat => {
            const namaKat = kat.nama_kategori || kat.kategori || kat.nama || `Kategori ${kat.id}`;
            select.innerHTML += `<option value="${kat.id}">${namaKat}</option>`;
        });
    } catch (error) {
        console.error('Gagal memuat kategori:', error);
    }
}

// 2. Ambil Data Buku (GET /api/buku) - Error Handling
// Ambil Data Buku (GET /api/buku)
async function loadBuku() {
    try {
        const response = await fetch('/api/buku');
        if (!response.ok) throw new Error('Gagal mengambil data buku');

        const result = await response.json();
        const tbody = document.querySelector('#tabelBuku tbody');
        tbody.innerHTML = '';

        result.data.forEach(item => {
            tbody.innerHTML += `
                <tr class="text-center">
                    <td class="border p-2">${item.kategori}</td>
                    <td class="border p-2">${item.judul}</td>
                    <td class="border p-2">${item.penulis}</td>
                    <td class="border p-2">${item.tahun}</td>
                    <td class="border p-2 flex justify-center gap-2">
                        <!-- Tombol Detail (Membuka show.blade.php) -->
                        <a href="/buku/${item.id}" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                            Detail
                        </a>
                        <!-- Tombol Edit -->
                        <button onclick="editBuku(${item.id})" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                            Edit
                        </button>
                        <!-- Tombol Hapus -->
                        <button onclick="hapusBuku(${item.id})" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                            Hapus
                        </button>
                    </td>
                </tr>
            `;
        });
    } catch (error) {
        console.error('Error:', error);
    }
}

// 3. Load Detail Buku (Edit Mode) - Error Handling (Soal 5)
async function editBuku(id) {
    sembunyikanError();
    try {
        const response = await fetch(`/api/buku/${id}`);
        if (!response.ok) {
            throw new Error('Data buku tidak ditemukan atau telah dihapus.');
        }

        const result = await response.json();
        const buku = result.data;

        document.getElementById('buku_id').value = buku.id;
        document.getElementById('kategori_id').value = buku.kategori_id;
        document.getElementById('judul').value = buku.judul;
        document.getElementById('penulis').value = buku.penulis;
        document.getElementById('tahun').value = buku.tahun;

        document.getElementById('formTitle').innerText = 'Formulir Edit Buku';
        document.getElementById('btnSubmit').innerText = 'Update Buku';
        document.getElementById('containerForm').classList.remove('hidden');

    } catch (error) {
        alert(error.message);
    }
}


// 4. Hapus Buku (DELETE /api/buku/{id}) - Error Handling (Soal 5)
async function hapusBuku(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus buku ini?')) return;

    try {
        const response = await fetch(`/api/buku/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json' }
        });

        const resData = await response.json();

        if (!response.ok) {
            throw new Error(resData.message || 'Gagal menghapus data dari server.');
        }

        alert('Buku berhasil dihapus!');
        loadBuku();

    } catch (error) {
        alert(error.message);
    }
}

// 5. Submit Handler (POST/PUT) - Error Handling Validasi HTTP 422 (Soal 5)
document.getElementById('formBuku').addEventListener('submit', async function(e) {
    e.preventDefault();
    sembunyikanError();

    const bukuId = document.getElementById('buku_id').value;
    const isEdit = bukuId !== '';

    const url = isEdit ? `/api/buku/${bukuId}` : '/api/buku';
    const method = isEdit ? 'PUT' : 'POST';

    const data = {
        kategori_id: document.getElementById('kategori_id').value,
        judul: document.getElementById('judul').value,
        penulis: document.getElementById('penulis').value,
        tahun_terbit: document.getElementById('tahun').value,
    };

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const resData = await response.json();

        // Tangani kesalahanHTTP 422 Validasi Gagal (Soal 5)
        if (!response.ok) {
            if (response.status === 422 && resData.errors) {
                let errorList = '<ul class="list-disc pl-5">';
                for (const field in resData.errors) {
                    resData.errors[field].forEach(err => {
                        errorList += `<li>${err}</li>`;
                    });
                }
                errorList += '</ul>';
                tampilkanError('<strong>Gagal Menyimpan Data:</strong>' + errorList);
                return;
            }
            throw new Error(resData.message || 'Terjadi kesalahan sistem.');
        }

        alert(isEdit ? 'Buku berhasil diperbarui!' : 'Buku berhasil ditambahkan!');
        tutupForm();
        loadBuku();

    } catch (error) {
        tampilkanError(`<strong>Error:</strong> ${error.message}`);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    loadBuku();
    loadKategori();
});
</script>
@endsection