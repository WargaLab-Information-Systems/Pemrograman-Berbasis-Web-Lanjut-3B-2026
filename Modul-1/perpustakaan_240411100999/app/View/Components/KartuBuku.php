<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class KartuBuku extends Component
{
    public $buku;

    public function __construct($buku)
    {
        $this->buku = $buku;
    }

    public function render(): View
    {
        return view('components.kartu-buku');
    }
}
