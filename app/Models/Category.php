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
            // Category slug always follows the category name.
            if (blank($category->name)) {
                return;
            }

            if (! $category->isDirty('name') && filled($category->slug)) {
                return;
            }

            $category->slug = $category->generateUniqueSlug($category->name);
        });
    }

    // Relation: one category can have many books.
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    // Attributes that can be filled through mass assignment.
    protected $fillable = [
        'name',
        'slug',         // URL-friendly version of name (created automatically)
    ];

    /**
     * Generate a unique slug based on the category name.
     */
    protected function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'category';

        $slug = $baseSlug;
        $counter = 2;

        // Check including soft-deleted data to ensure category slug remains unique.
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
