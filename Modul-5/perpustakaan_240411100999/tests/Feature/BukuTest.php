<?php

namespace Tests\Feature;

use Tests\TestCase;

class BukuTest extends TestCase
{
    public function test_buku_index_page_displays_books_with_correct_image_paths(): void
    {
        $response = $this->get('/buku');

        $response->assertStatus(200);
        $response->assertSee('Daftar Buku');
        $response->assertSee('images/Laskar Pelangi.jpg');
        $response->assertSee('images/Bumi.jpg');
        $response->assertDontSee('public/images/');
    }

    public function test_buku_detail_page_displays_correct_book_image(): void
    {
        $response = $this->get('/buku/1');

        $response->assertStatus(200);
        $response->assertSee('Laskar Pelangi');
        $response->assertSee('images/Laskar Pelangi.jpg');
        $response->assertDontSee('src="http://localhost/1"', false);
    }
}
