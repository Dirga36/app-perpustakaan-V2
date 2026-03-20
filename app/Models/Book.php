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
            // Slug selalu disinkronkan dari judul buku agar URL tetap konsisten.
            if (blank($book->title)) {
                return;
            }

            if (! $book->isDirty('title') && filled($book->slug)) {
                return;
            }

            $book->slug = $book->generateUniqueSlug($book->title);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $fillable = [
        'title',
        'authorName',
        'ISBN',
        'publishedYear',
        'coverImage',
        'category_id',
        'slug',         // Versi URL-friendly dari nama (dibuat otomatis)
    ];

    /**
     * Menjadikan slug sebagai route key untuk URL detail buku.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Membuat slug unik berbasis judul buku.
     */
    protected function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'book';

        $slug = $baseSlug;
        $counter = 2;

        while (static::withTrashed()
            ->where('slug', $slug)
            ->whereKeyNot($this->getKey())
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}