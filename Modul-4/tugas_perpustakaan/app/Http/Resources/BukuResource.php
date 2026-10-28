<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'kategori_id' => $this->kategori_id,
            // Mengecek kolom nama_kategori, kategori, atau nama yang ada di tabel kategoris
            'kategori'    => $this->kategori->nama_kategori 
                             ?? $this->kategori->kategori 
                             ?? $this->kategori->nama 
                             ?? $this->kategori_id,
            'judul'       => $this->judul,
            'penulis'     => $this->penulis,
            'tahun'       => $this->tahun_terbit,
        ];
    }
}