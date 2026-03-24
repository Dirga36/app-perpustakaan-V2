<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted(): void
    {
        static::saving(function (Category $category): void {
            // Slug kategori selalu mengikuti nama kategori.
            if (blank($category->name)) {
                return;
            }

            if (! $category->isDirty('name') && filled($category->slug)) {
                return;
            }

            $category->slug = $category->generateUniqueSlug($category->name);
        });
    }

    // Relasi: satu kategori dapat memiliki banyak buku.
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    // Atribut yang boleh diisi melalui mass assignment.
    protected $fillable = [
        'name',
        'slug',         // Versi URL-friendly dari nama (dibuat otomatis)
    ];

    /**
     * Membuat slug unik berbasis nama kategori.
     */
    protected function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'category';

        $slug = $baseSlug;
        $counter = 2;

        // Cek termasuk data soft-deleted agar slug kategori tetap unik.
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
