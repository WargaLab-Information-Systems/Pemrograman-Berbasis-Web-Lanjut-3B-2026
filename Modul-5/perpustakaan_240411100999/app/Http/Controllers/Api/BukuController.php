<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // GET /api/buku?cari=&kategori=&tahun=&page=
    public function index(Request $request)
    {
        $buku = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($request->cari, function ($q, $cari) {
                $q->where(function ($w) use ($cari) {
                    $w->where('judul', 'like', "%{$cari}%")
                      ->orWhere('penulis', 'like', "%{$cari}%");
                });
            })
            ->when($request->kategori, fn ($q, $k) => $q->where('kategori_id', $k))
            ->when($request->tahun, fn ($q, $t) => $q->where('tahun_terbit', $t))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return BukuResource::collection($buku);
    }

    // POST /api/buku
    public function store(Request $request)
    {
        $data = $request->validate(
            $this->aturan(),
            $this->pesan(),
            $this->atribut()
        );

        $buku = Buku::create($data)->load('kategori');

        return (new BukuResource($buku))
            ->response()
            ->setStatusCode(201);
    }

    // GET /api/buku/{id}
    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])
            ->withCount('peminjamans')
            ->findOrFail($id);

        return new BukuResource($buku);
    }

    // PUT /api/buku/{id}
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $data = $request->validate(
            $this->aturan(),
            $this->pesan(),
            $this->atribut()
        );

        $buku->update($data);

        return new BukuResource($buku->load('kategori'));
    }

    // DELETE /api/buku/{id}
    public function destroy($id)
    {
        Buku::findOrFail($id)->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }

    private function aturan(): array
    {
        return [
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|min:3|max:150',
            'penulis'      => 'required|string|min:3|max:100',
            'tahun_terbit' => 'required|integer|between:1900,' . date('Y'),
        ];
    }

    private function pesan(): array
    {
        return [
            'required'             => ':attribute wajib diisi.',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'judul.string'         => 'Judul buku harus berupa teks.',
            'judul.min'            => 'Judul buku minimal :min karakter.',
            'judul.max'            => 'Judul buku maksimal :max karakter.',
            'penulis.string'       => 'Penulis harus berupa teks.',
            'penulis.min'          => 'Penulis minimal :min karakter.',
            'penulis.max'          => 'Penulis maksimal :max karakter.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa bilangan bulat.',
            'tahun_terbit.between' => 'Tahun terbit harus antara 1900 sampai ' . date('Y') . '.',
        ];
    }

    private function atribut(): array
    {
        return [
            'kategori_id'  => 'Kategori',
            'judul'        => 'Judul buku',
            'penulis'      => 'Penulis',
            'tahun_terbit' => 'Tahun terbit',
        ];
    }
}