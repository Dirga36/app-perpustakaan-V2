<x-layouts.public-portal title="Home">
    <section class="mb-10 overflow-hidden rounded-3xl border border-slate-200/70 bg-white/80 p-7 shadow-sm sm:p-10">
        <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
            <div>
                <p class="mb-3 inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-blue-800">
                    Welcome to Project Library VI
                </p>
                <h1 class="font-display text-4xl font-bold leading-tight text-slate-900 sm:text-5xl">
                    Find your next favorite book in a focused, clean public catalog.
                </h1>
                <p class="mt-4 max-w-xl text-slate-600">
                    Discover curated titles by category, check book metadata, and preview reading details.
                    This portal intentionally keeps reading as metadata-only preview for now.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('public.books.index') }}"
                        class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                        Explore Catalog
                    </a>
                    <a href="{{ route('public.about') }}"
                        class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-100">
                        About & Contact
                    </a>
                </div>
            </div>
            <div class="card-frost rounded-2xl p-5">
                <h2 class="font-display text-2xl font-semibold text-slate-900">Library Snapshot</h2>
                <div class="mt-5 grid grid-cols-2 gap-4">
                    <div class="rounded-xl bg-white p-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Books</p>
                        <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $totalBooks }}</p>
                    </div>
                    <div class="rounded-xl bg-white p-4 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Categories</p>
                        <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $totalCategories }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="mb-5 flex items-end justify-between gap-4">
            <div>
                <h2 class="font-display text-3xl font-bold text-slate-900">Recently Added Books</h2>
                <p class="mt-1 text-slate-600">Fresh picks from the collection.</p>
            </div>
            <a href="{{ route('public.books.index') }}" class="text-sm font-bold text-blue-700 hover:text-blue-800">
                View all books
            </a>
        </div>

        @if ($latestBooks->isEmpty())
            <div class="card-frost rounded-2xl p-8 text-center text-slate-600">
                No books available yet.
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($latestBooks as $book)
                    @php
                        $coverUrl = str_starts_with($book->coverImage, 'http://') || str_starts_with($book->coverImage, 'https://')
                            ? $book->coverImage
                            : asset('storage/' . ltrim($book->coverImage, '/'));
                    @endphp
                    <article class="card-frost overflow-hidden rounded-2xl shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <img src="{{ $coverUrl }}" alt="Cover of {{ $book->title }}" class="h-56 w-full object-cover">
                        <div class="p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-blue-700">
                                {{ $book->category?->name ?? 'Uncategorized' }}
                            </p>
                            <h3 class="mt-1 line-clamp-2 text-lg font-bold text-slate-900">{{ $book->title }}</h3>
                            <p class="mt-1 text-sm text-slate-600">By {{ $book->authorName }}</p>
                            <a href="{{ route('public.books.show', $book) }}"
                                class="mt-4 inline-flex text-sm font-bold text-slate-900 hover:text-blue-700">
                                Read metadata preview
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.public-portal>
