<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Perpustakaan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div>
                <h3 class="mb-2 font-semibold">Rekap Buku per Kategori</h3>
                <div id="rekap1" class="overflow-x-auto rounded-lg bg-white p-3 text-sm shadow-sm">Memuat...</div>
            </div>
            <div>
                <h3 class="mb-2 font-semibold">Rekap Peminjaman per Buku</h3>
                <div id="rekap2" class="overflow-x-auto rounded-lg bg-white p-3 text-sm shadow-sm">Memuat...</div>
            </div>
        </div>
    </div>

    <script>
    async function muatRekap(url, el) {
        try {
            const r = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if (!r.ok) throw new Error('Status ' + r.status);
            const body = await r.json();
            const rows = Array.isArray(body) ? body : (body.data ?? []);

            el.textContent = '';
            if (!Array.isArray(rows) || rows.length === 0) {
                el.textContent = 'Belum ada data.';
                return;
            }

            const kolom = Object.keys(rows[0]);
            const tabel = document.createElement('table');
            tabel.className = 'min-w-full text-left';

            const head = tabel.createTHead().insertRow();
            kolom.forEach(k => {
                const th = document.createElement('th');
                th.className = 'p-2';
                th.textContent = k;
                head.appendChild(th);
            });

            const body2 = tabel.createTBody();
            rows.forEach(row => {
                const tr = body2.insertRow();
                tr.className = 'border-t';
                kolom.forEach(k => {
                    const td = tr.insertCell();
                    td.className = 'p-2';
                    td.textContent = row[k] ?? '-';
                });
            });

            el.appendChild(tabel);
        } catch (err) {
            el.textContent = 'Gagal memuat data: ' + err.message;
        }
    }

    muatRekap('/api/rekap/buku-per-kategori', document.getElementById('rekap1'));
    muatRekap('/api/rekap/peminjaman-per-buku', document.getElementById('rekap2'));
    </script>
</x-app-layout>