<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;

class PublicHomeController extends Controller
{
    public function index()
    {
        // Ambil buku terbaru untuk ditampilkan di hero/section unggulan.
        $latestBooks = Book::query()
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        // Kirim ringkasan statistik katalog ke halaman depan.
        return view('welcome', [
            'latestBooks' => $latestBooks,
            'totalBooks' => Book::count(),
            'totalCategories' => Category::count(),
        ]);
    }

    public function about()
    {
        // Tampilkan halaman statis tentang aplikasi perpustakaan.
        return view('public-portal.about');
    }
}
