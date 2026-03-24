<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted(): void
    {
        static::saving(function (Book $book): void {
            // Slug is always synchronized from book title to keep URLs consistent.
            if (blank($book->title)) {
                return;
            }

            if (! $book->isDirty('title') && filled($book->slug)) {
                return;
            }

            $book->slug = $book->generateUniqueSlug($book->title);
        });
    }

    // Relation: each book belongs to one category.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Attributes that can be filled through mass assignment.
    protected $fillable = [
        'title',
        'authorName',
        'ISBN',
        'publishedYear',
        'coverImage',
        'category_id',
        'slug',         // URL-friendly version of name (created automatically)
    ];

    /**
     * Make slug the route key for book detail URLs.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Generate a unique slug based on the book title.
     */
    protected function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'book';

        $slug = $baseSlug;
        $counter = 2;

        // Check including soft-deleted data to ensure slug is truly unique.
        while (static::withTrashed()
            ->where('slug', $slug)
            ->whereKeyNot($this->getKey())
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
