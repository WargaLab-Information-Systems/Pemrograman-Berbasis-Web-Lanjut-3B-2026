<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BookCard extends Component
{
    public $id;
    public $judul;
    public $penulis;
    public $tahun;
    public $kategori;
    public $poster;
    
    public function __construct($id, $judul, $penulis, $tahun, $kategori, $poster)
    {
        $this->id = $id;
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->tahun = $tahun;
        $this->kategori = $kategori;
        $this->poster = $poster;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.book-card');
    }
}
