<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicBookController extends Controller
{
    public function index(Request $request)
    {
        // List of allowed sorting options from the query string.
        $allowedSorts = ['latest', 'oldest', 'title_asc', 'title_desc', 'year_desc', 'year_asc'];

        // Normalize search keyword for consistency and limit input length.
        $search = preg_replace('/\s+/', ' ', trim((string) $request->query('search', '')));
        $search = mb_substr($search ?? '', 0, 120);

        // Ensure category filter only accepts valid numeric IDs.
        $categoryInput = filter_var(
            $request->query('category'),
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]],
        );

        $selectedCategory = $categoryInput !== false ? (int) $categoryInput : null;

        if ($selectedCategory !== null && ! Category::query()->whereKey($selectedCategory)->exists()) {
            $selectedCategory = null;
        }

        // Fallback to default sorting if sort value is unknown.
        $sort = (string) $request->query('sort', 'latest');

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'latest';
        }

        // Build dynamic query based on search and category.
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

        // Apply sorting strategy according to user preference.
        $booksQuery = match ($sort) {
            'oldest' => $booksQuery->oldest(),
            'title_asc' => $booksQuery->orderBy('title'),
            'title_desc' => $booksQuery->orderByDesc('title'),
            'year_desc' => $booksQuery->orderByDesc('publishedYear')->orderByDesc('created_at'),
            'year_asc' => $booksQuery->orderBy('publishedYear')->orderByDesc('created_at'),
            default => $booksQuery->latest(),
        };

        // Pagination preserves query string to keep filters active.
        $books = $booksQuery
            ->paginate(12)
            ->withQueryString();

        // Category data is used for dropdown filter on the catalog page.
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
        // Load category relation for book detail information.
        $book->load('category');

        // Fetch similar book recommendations from the same category.
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
