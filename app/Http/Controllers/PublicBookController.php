<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicBookController extends Controller
{
    public function index(Request $request)
    {
        // Daftar opsi urutan yang diizinkan dari query string.
        $allowedSorts = ['latest', 'oldest', 'title_asc', 'title_desc', 'year_desc', 'year_asc'];

        // Normalisasi kata kunci agar konsisten dan batasi panjang input.
        $search = preg_replace('/\s+/', ' ', trim((string) $request->query('search', '')));
        $search = mb_substr($search ?? '', 0, 120);

        // Pastikan filter kategori hanya menerima angka id valid.
        $categoryInput = filter_var(
            $request->query('category'),
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]],
        );

        $selectedCategory = $categoryInput !== false ? (int) $categoryInput : null;

        if ($selectedCategory !== null && ! Category::query()->whereKey($selectedCategory)->exists()) {
            $selectedCategory = null;
        }

        // Fallback ke urutan default jika nilai sort tidak dikenal.
        $sort = (string) $request->query('sort', 'latest');

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'latest';
        }

        // Bangun query dinamis berdasarkan pencarian dan kategori.
        $booksQuery = Book::query()
            ->with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($bookQuery) use ($search) {
                    $bookQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('authorName', 'like', "%{$search}%")
                        ->orWhere('ISBN', 'like', "%{$search}%");
                });
            })
            ->when($selectedCategory !== null, function ($query) use ($selectedCategory) {
                $query->where('category_id', $selectedCategory);
            });

        // Terapkan strategi sorting sesuai opsi pengguna.
        $booksQuery = match ($sort) {
            'oldest' => $booksQuery->oldest(),
            'title_asc' => $booksQuery->orderBy('title'),
            'title_desc' => $booksQuery->orderByDesc('title'),
            'year_desc' => $booksQuery->orderByDesc('publishedYear')->orderByDesc('created_at'),
            'year_asc' => $booksQuery->orderBy('publishedYear')->orderByDesc('created_at'),
            default => $booksQuery->latest(),
        };

        // Pagination mempertahankan query string agar filter tetap aktif.
        $books = $booksQuery
            ->paginate(12)
            ->withQueryString();

        // Data kategori dipakai untuk dropdown filter pada halaman katalog.
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('public-portal.books.index', [
            'books' => $books,
            'categories' => $categories,
            'search' => $search,
            'selectedCategory' => $selectedCategory,
            'sort' => $sort,
        ]);
    }

    public function show(Book $book)
    {
        // Muat relasi kategori untuk informasi detail buku.
        $book->load('category');

        // Ambil rekomendasi buku serupa dari kategori yang sama.
        $relatedBooks = Book::query()
            ->with('category')
            ->where('category_id', $book->category_id)
            ->whereKeyNot($book->id)
            ->latest()
            ->take(4)
            ->get();

        return view('public-portal.books.show', [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
        ]);
    }
}
