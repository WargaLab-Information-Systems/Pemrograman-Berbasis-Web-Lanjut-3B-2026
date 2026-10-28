@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

    <section id="daftar-buku" class="mt-3">
        <div class="container mb-3">
            <div class="row mb-3 text-center">
                <div class="col">
                    <h2> Daftar Buku </h2>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($buku as $item)
                    <div class="col-sm-3 mb-3" style="width: 380px;">
                        <x-book-card :id="$item['id']" :judul="$item['judul']" :penulis="$item['penulis']" :tahun="$item['tahun']"
                            :kategori="$item['kategori']" :poster="$item['poster']">
                        </x-book-card>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


@endsection
