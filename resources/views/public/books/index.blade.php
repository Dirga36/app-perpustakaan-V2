<x-layouts.public title="Book Catalog">
    <section class="mb-7 rounded-3xl border border-slate-200/70 bg-white/80 p-6 shadow-sm sm:p-8">
        <div class="mb-5 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="font-display text-4xl font-bold text-slate-900">Book Catalog</h1>
                <p class="mt-1 text-slate-600">Browse all available books and filter by category.</p>
            </div>
            <p class="text-sm font-semibold text-slate-500">{{ $books->total() }} result(s)</p>
        </div>

        <form method="GET" action="{{ route('public.books.index') }}" class="grid gap-3 sm:grid-cols-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search title, author, ISBN"
                class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none ring-orange-300 transition focus:ring-2">

            <select name="category"
                class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none ring-orange-300 transition focus:ring-2">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategory === $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800">
                Apply Filters
            </button>
        </form>
    </section>

    @if ($books->isEmpty())
        <div class="card-frost rounded-2xl p-8 text-center text-slate-600">
            No books match your current filters.
        </div>
    @else
        <section class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($books as $book)
                @php
                    $coverUrl = str_starts_with($book->coverImage, 'http://') || str_starts_with($book->coverImage, 'https://')
                        ? $book->coverImage
                        : asset('storage/' . ltrim($book->coverImage, '/'));
                @endphp
                <article class="card-frost overflow-hidden rounded-2xl shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <img src="{{ $coverUrl }}" alt="Cover of {{ $book->title }}" class="h-56 w-full object-cover">
                    <div class="p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-orange-700">
                            {{ $book->category?->name ?? 'Uncategorized' }}
                        </p>
                        <h2 class="mt-1 line-clamp-2 text-lg font-bold text-slate-900">{{ $book->title }}</h2>
                        <p class="mt-1 text-sm text-slate-600">By {{ $book->authorName }}</p>
                        <p class="mt-1 text-sm text-slate-500">Published: {{ $book->publishedYear }}</p>

                        <a href="{{ route('public.books.show', $book) }}"
                            class="mt-4 inline-flex text-sm font-bold text-slate-900 hover:text-orange-700">
                            Open detail
                        </a>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="mt-8">
            {{ $books->links() }}
        </div>
    @endif
</x-layouts.public>
