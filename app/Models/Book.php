<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_book');
    }

    protected $fillable = [
        'title',
        'authorName',
        'ISBN',
        'publishedYear',
        'coverImage',
    ];
}