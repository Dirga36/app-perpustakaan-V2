<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;

class PublicHomeController extends Controller
{
    public function index()
    {
        // Fetch the latest books to display in the hero/featured section.
        $latestBooks = Book::query()
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        // Send catalog statistics summary to the home page.
        return view('welcome', [
            'latestBooks' => $latestBooks,
            'totalBooks' => Book::count(),
            'totalCategories' => Category::count(),
        ]);
    }

    public function about()
    {
        // Display the static page about the library application.
        return view('public-portal.about');
    }
}
