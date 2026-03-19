<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;

class PublicHomeController extends Controller
{
    public function index()
    {
        $latestBooks = Book::query()
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', [
            'latestBooks' => $latestBooks,
            'totalBooks' => Book::count(),
            'totalCategories' => Category::count(),
        ]);
    }

    public function about()
    {
        return view('public.about');
    }
}
