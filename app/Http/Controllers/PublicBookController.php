<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicBookController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->string('search'));
        $selectedCategory = $request->integer('category');
        $sort = (string) $request->string('sort', 'latest');

        if (! in_array($sort, ['latest', 'oldest', 'title_asc', 'title_desc', 'year_desc', 'year_asc'], true)) {
            $sort = 'latest';
        }

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
            ->when($selectedCategory > 0, function ($query) use ($selectedCategory) {
                $query->where('category_id', $selectedCategory);
            });

        $booksQuery = match ($sort) {
            'oldest' => $booksQuery->oldest(),
            'title_asc' => $booksQuery->orderBy('title'),
            'title_desc' => $booksQuery->orderByDesc('title'),
            'year_desc' => $booksQuery->orderByDesc('publishedYear')->orderByDesc('created_at'),
            'year_asc' => $booksQuery->orderBy('publishedYear')->orderByDesc('created_at'),
            default => $booksQuery->latest(),
        };

        $books = $booksQuery
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('public.books.index', [
            'books' => $books,
            'categories' => $categories,
            'search' => $search,
            'selectedCategory' => $selectedCategory,
            'sort' => $sort,
        ]);
    }

    public function show(Book $book)
    {
        $book->load('category');

        $relatedBooks = Book::query()
            ->with('category')
            ->where('category_id', $book->category_id)
            ->whereKeyNot($book->id)
            ->latest()
            ->take(4)
            ->get();

        return view('public.books.show', [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
        ]);
    }
}
