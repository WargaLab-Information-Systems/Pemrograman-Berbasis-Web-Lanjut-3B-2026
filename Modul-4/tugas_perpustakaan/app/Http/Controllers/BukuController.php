<?php

namespace App\Http\Controllers;

use App\Models\Kategori; // Tambahkan import Kategori
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        // Ambil semua data kategori dari database
        $kategori = Kategori::all();

        // Kirimkan variabel $kategori ke view
        return view('buku.index', compact('kategori'));
    }
    public function show($id)
    {
        return view('buku.show', compact('id'));
    }
}