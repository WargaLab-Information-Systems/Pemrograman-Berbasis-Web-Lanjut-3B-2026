@php $kelola = request()->routeIs('buku.kelola'); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Buku</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $kelola ? 'Kelola Data Buku' : 'Daftar Buku' }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>

    <div id="pesan" class="alert d-none" role="alert"></div>

        <div class="card mb-4" @unless ($kelola) style="display:none" @endunless>
        <div class="card-header" id="judulForm">Tambah Buku</div>
        <div class="card-body">
            <form id="formBuku" novalidate>
                <input type="hidden" id="bukuId">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select id="kategori_id" class="form-select">
                            <option value="">-- Pilih kategori --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" id="judul" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" id="penulis" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number" id="tahun_terbit" class="form-control">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" id="btnBatal" class="btn btn-secondary d-none">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped bg-white">
        <thead>
            <tr>
                <th style="width:60px">No</th>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th style="width:160px">{{ $kelola ? 'Aksi' : 'Detail' }}</th>
            </tr>
        </thead>
        <tbody id="tabelBuku"></tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
        <button id="btnPrev" class="btn btn-outline-secondary btn-sm">&laquo; Sebelumnya</button>
        <span id="infoHalaman" class="text-muted small"></span>
        <button id="btnNext" class="btn btn-outline-secondary btn-sm">Berikutnya &raquo;</button>
    </div>
</div>

<script>
const API_BUKU = '/api/buku';
const KELOLA   = @json($kelola);
const CSRF     = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const API_KATEGORI = '/api/kategori';

const form        = document.getElementById('formBuku');
const inputId     = document.getElementById('bukuId');
const f = {
    kategori_id:  document.getElementById('kategori_id'),
    judul:        document.getElementById('judul'),
    penulis:      document.getElementById('penulis'),
    tahun_terbit: document.getElementById('tahun_terbit'),
};
const tabel       = document.getElementById('tabelBuku');
const pesan       = document.getElementById('pesan');
const judulForm   = document.getElementById('judulForm');
const btnBatal    = document.getElementById('btnBatal');
const btnPrev     = document.getElementById('btnPrev');
const btnNext     = document.getElementById('btnNext');
const infoHalaman = document.getElementById('infoHalaman');

let halaman = 1;
let meta = { current_page: 1, last_page: 1, from: 0 };

/* ---------- Helper ---------- */

function tampilPesan(teks, tipe = 'success') {
    pesan.className = `alert alert-${tipe}`;
    pesan.textContent = teks;
}
function hapusPesan() {
    pesan.className = 'alert d-none';
    pesan.textContent = '';
}

async function kirimRequest(url, options = {}) {
    let response;
    try {
        response = await fetch(url, {
            ...options,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                ...(options.headers || {}),
            },
        });
    } catch (err) {
        throw new Error('API tidak dapat diakses. Periksa koneksi atau pastikan server berjalan.');
    }

    const body = await response.json().catch(() => ({}));

    if (!response.ok) {
        if (response.status === 422 && body.errors) {
            throw new Error(Object.values(body.errors).flat().join(' '));
        }
        if (response.status === 404) {
            throw new Error('Data tidak ditemukan.');
        }
        throw new Error(body.message || `Permintaan gagal (status ${response.status}).`);
    }
    return body;
}

/* ---------- Dropdown kategori ---------- */

async function muatKategori() {
    try {
        const hasil = await kirimRequest(API_KATEGORI);
        hasil.data.forEach(k => {
            const opt = document.createElement('option');
            opt.value = k.id;
            opt.textContent = k.nama;
            f.kategori_id.appendChild(opt);
        });
    } catch (err) {
        tampilPesan('Gagal memuat daftar kategori. ' + err.message, 'danger');
    }
}

/* ---------- READ: GET /api/buku ---------- */

async function muatBuku(page = halaman) {
    try {
        const hasil = await kirimRequest(`${API_BUKU}?page=${page}`);
        halaman = hasil.meta.current_page;
        meta = hasil.meta;
        renderTabel(hasil.data);
    } catch (err) {
        tabel.innerHTML = '';
        tampilPesan('Gagal memuat data buku. ' + err.message, 'danger');
    }
}

function renderTabel(daftar) {
    tabel.innerHTML = '';

    if (daftar.length === 0 && halaman > 1) {
        return muatBuku(halaman - 1);
    }

    if (daftar.length === 0) {
        const td = tabel.insertRow().insertCell();
        td.colSpan = 6;
        td.className = 'text-center text-muted';
        td.textContent = 'Belum ada data buku.';
    }

    daftar.forEach((buku, i) => {
        const tr = tabel.insertRow();
        [meta.from + i, buku.kategori, buku.judul, buku.penulis, buku.tahun]
            .forEach(v => { tr.insertCell().textContent = v ?? '-'; });

                const aksi = tr.insertCell();

        if (KELOLA) {
            const btnUbah = document.createElement('button');
            btnUbah.className = 'btn btn-warning btn-sm me-1';
            btnUbah.textContent = 'Ubah';
            btnUbah.addEventListener('click', () => isiFormUbah(buku));

            const btnHapus = document.createElement('button');
            btnHapus.className = 'btn btn-danger btn-sm';
            btnHapus.textContent = 'Hapus';
            btnHapus.addEventListener('click', () => hapusBuku(buku));

            aksi.append(btnUbah, btnHapus);
        } else {
            const a = document.createElement('a');
            a.className = 'btn btn-outline-primary btn-sm';
            a.href = `/buku/${buku.id}`;
            a.textContent = 'Lihat';
            aksi.append(a);
        }
    });

    infoHalaman.textContent = `Halaman ${meta.current_page} dari ${meta.last_page}`;
    btnPrev.disabled = meta.current_page <= 1;
    btnNext.disabled = meta.current_page >= meta.last_page;
}

btnPrev.addEventListener('click', () => muatBuku(halaman - 1));
btnNext.addEventListener('click', () => muatBuku(halaman + 1));

/* ---------- CREATE (POST) & UPDATE (PUT) ---------- */

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    hapusPesan();

    const id = inputId.value;
    const payload = {
        kategori_id:  f.kategori_id.value,
        judul:        f.judul.value.trim(),
        penulis:      f.penulis.value.trim(),
        tahun_terbit: f.tahun_terbit.value,
    };

    try {
        if (id) {
            await kirimRequest(`${API_BUKU}/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
            tampilPesan('Buku berhasil diubah.');
            resetForm();
            await muatBuku(halaman);
        } else {
            await kirimRequest(API_BUKU, { method: 'POST', body: JSON.stringify(payload) });
            tampilPesan('Buku berhasil ditambahkan.');
            resetForm();
            await muatBuku(1);
        }
    } catch (err) {
        tampilPesan((id ? 'Gagal mengubah buku. ' : 'Gagal menambahkan buku. ') + err.message, 'danger');
    }
});

function isiFormUbah(buku) {
    hapusPesan();
    inputId.value        = buku.id;
    f.kategori_id.value  = buku.kategori_id;
    f.judul.value        = buku.judul;
    f.penulis.value      = buku.penulis;
    f.tahun_terbit.value = buku.tahun;

    judulForm.textContent = 'Ubah Buku';
    btnBatal.classList.remove('d-none');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    form.reset();
    inputId.value = '';
    judulForm.textContent = 'Tambah Buku';
    btnBatal.classList.add('d-none');
}
btnBatal.addEventListener('click', () => { resetForm(); hapusPesan(); });

/* ---------- DELETE ---------- */

async function hapusBuku(buku) {
    if (!confirm(`Yakin ingin menghapus buku "${buku.judul}"?`)) return;

    try {
        await kirimRequest(`${API_BUKU}/${buku.id}`, { method: 'DELETE' });
        tampilPesan('Buku berhasil dihapus.');
        if (inputId.value == buku.id) resetForm();
        await muatBuku(halaman);
    } catch (err) {
        tampilPesan('Gagal menghapus buku. ' + err.message, 'danger');
    }
}

/* ---------- Mulai ---------- */
muatKategori();
muatBuku(1);
</script>
</body>
</html>