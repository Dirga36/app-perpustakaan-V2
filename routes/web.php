<?php

use App\Http\Controllers\PublicBookController;
use App\Http\Controllers\PublicHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicHomeController::class, 'index'])->name('public.home');
Route::get('/books', [PublicBookController::class, 'index'])->name('public.books.index');
Route::get('/books/{book}', [PublicBookController::class, 'show'])->name('public.books.show');
Route::get('/about', [PublicHomeController::class, 'about'])->name('public.about');
