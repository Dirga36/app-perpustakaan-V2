<x-layouts.public-portal :title="$book->title">
    <a href="{{ route('public.books.index') }}" class="mb-5 inline-flex text-sm font-bold text-slate-700 hover:text-blue-700">
        ← Back to catalog
    </a>

    @php
        $coverUrl = str_starts_with($book->coverImage, 'http://') || str_starts_with($book->coverImage, 'https://')
            ? $book->coverImage
            : asset('storage/' . ltrim($book->coverImage, '/'));
    @endphp

    <section class="grid gap-6 lg:grid-cols-[320px_1fr]">
        <div class="card-frost overflow-hidden rounded-3xl shadow-sm">
            <img src="{{ $coverUrl }}" alt="Cover of {{ $book->title }}" class="h-full min-h-100 w-full object-cover">
        </div>

        <div class="card-frost rounded-3xl p-6 sm:p-8">
            <p class="text-xs font-semibold uppercase tracking-wider text-blue-700">
                {{ $book->category?->name ?? 'Uncategorized' }}
            </p>
            <h1 class="font-display mt-2 text-4xl font-bold text-slate-900">{{ $book->title }}</h1>
            <p class="mt-2 text-lg text-slate-700">By {{ $book->authorName }}</p>

            <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-white p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">ISBN</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-900">{{ $book->ISBN }}</dd>
                </div>
                <div class="rounded-2xl bg-white p-4">
                    <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Published Year</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-900">{{ $book->publishedYear }}</dd>
                </div>
            </dl>

            <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4">
                <h2 class="font-display text-2xl font-bold text-slate-900">Reading Preview (Metadata Only)</h2>
                <p class="mt-2 text-sm text-slate-600">
                    Full reading, embedded viewer, and file download are intentionally disabled in this phase.
                    This page currently provides bibliographic metadata preview only.
                </p>
            </div>
        </div>
    </section>

    <section class="mt-10">
        <h2 class="font-display text-2xl font-bold text-slate-900">More in this category</h2>

        @if ($relatedBooks->isEmpty())
            <p class="mt-3 text-sm text-slate-600">No related books found.</p>
        @else
            <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($relatedBooks as $relatedBook)
                    <a href="{{ route('public.books.show', $relatedBook) }}"
                        class="card-frost rounded-2xl p-4 transition hover:-translate-y-0.5 hover:shadow-sm">
                        <p class="line-clamp-2 font-bold text-slate-900">{{ $relatedBook->title }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $relatedBook->authorName }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.public-portal>
