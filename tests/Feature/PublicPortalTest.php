<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_return_success_status(): void
    {
        $category = Category::factory()->create();
        $book = Book::factory()->for($category)->create();

        $this->get(route('public.home'))->assertOk();
        $this->get(route('public.books.index'))->assertOk();
        $this->get(route('public.books.show', $book))->assertOk();
        $this->get(route('public.about'))->assertOk();
    }

    public function test_catalog_search_filter_and_sort_work(): void
    {
        $science = Category::factory()->create(['name' => 'Science']);
        $history = Category::factory()->create(['name' => 'History']);

        $targetBook = Book::factory()->for($science)->create([
            'title' => 'Quantum Pathways',
            'authorName' => 'Alice Newton',
            'ISBN' => '9781234567890',
            'publishedYear' => '2024',
        ]);

        Book::factory()->for($history)->create([
            'title' => 'Ancient Empires',
            'authorName' => 'Brian Stone',
            'ISBN' => '9780000000001',
            'publishedYear' => '2010',
        ]);

        $response = $this->get(route('public.books.index', [
            'search' => 'Quantum',
            'category' => $science->id,
            'sort' => 'title_asc',
        ]));

        $response
            ->assertOk()
            ->assertSee('Quantum Pathways')
            ->assertSee('Science')
            ->assertDontSee('Ancient Empires');

        $response->assertViewHas('search', 'Quantum');
        $response->assertViewHas('selectedCategory', $science->id);
        $response->assertViewHas('sort', 'title_asc');

        $this->assertTrue($response->viewData('books')->contains($targetBook));
    }

    public function test_catalog_ignores_invalid_filter_params_safely(): void
    {
        Category::factory()->create(['name' => 'General']);
        Book::factory()->create(['title' => 'Sample Book']);

        $response = $this->get(route('public.books.index', [
            'search' => str_repeat('A', 300),
            'category' => '-99',
            'sort' => 'invalid_sort',
        ]));

        $response->assertOk()->assertSee('No books match your current filters.');
        $response->assertViewHas('sort', 'latest');
        $response->assertViewHas('selectedCategory', null);
        $this->assertSame(120, mb_strlen($response->viewData('search')));
    }

    public function test_soft_deleted_books_return_404_on_detail_page(): void
    {
        $book = Book::factory()->create();
        $book->delete();

        $this->get(route('public.books.show', $book->id))->assertNotFound();
    }
}
