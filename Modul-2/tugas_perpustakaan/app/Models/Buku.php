<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // Pastikan fillable Anda sudah sesuai
    protected $fillable = [
        'judul',
        'penulis',
        'tahun_terbit',
        'kategori_id',
    ];

    /**
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**

     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
