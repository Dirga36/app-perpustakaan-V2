<header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/80 backdrop-blur-md">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('public.home') }}" class="font-display text-2xl font-bold tracking-tight text-slate-900">
            BookNest
        </a>

        <nav class="flex items-center gap-2 text-sm font-semibold text-slate-700 sm:gap-4">
            <a href="{{ route('public.home') }}"
                class="rounded-full px-3 py-1.5 transition {{ request()->routeIs('public.home') ? 'bg-slate-900 text-white' : 'hover:bg-slate-100' }}">
                Home
            </a>
            <a href="{{ route('public.books.index') }}"
                class="rounded-full px-3 py-1.5 transition {{ request()->routeIs('public.books.*') ? 'bg-slate-900 text-white' : 'hover:bg-slate-100' }}">
                Catalog
            </a>
            <a href="{{ route('public.about') }}"
                class="rounded-full px-3 py-1.5 transition {{ request()->routeIs('public.about') ? 'bg-slate-900 text-white' : 'hover:bg-slate-100' }}">
                About & Contact
            </a>
        </nav>
    </div>
</header>
