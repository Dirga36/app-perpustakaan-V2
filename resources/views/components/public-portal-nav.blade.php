<header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/80 backdrop-blur-md">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('public.home') }}" class="flex items-center gap-3 font-display text-2xl font-bold tracking-tight text-slate-900">
            <img src="{{ asset('logo.svg') }}" alt="Logo Project Library VI" class="h-10 w-10 rounded-lg object-contain">
            <span>Project Library VI</span>
        </a>

        <nav class="hidden items-center gap-2 text-sm font-semibold text-slate-700 md:flex md:gap-4">
            <a href="{{ route('public.home') }}"
                class="rounded-full px-3 py-1.5 transition {{ request()->routeIs('public.home') ? 'bg-blue-900 text-white' : 'hover:bg-slate-100' }}">
                Home
            </a>
            <a href="{{ route('public.books.index') }}"
                class="rounded-full px-3 py-1.5 transition {{ request()->routeIs('public.books.*') ? 'bg-blue-900 text-white' : 'hover:bg-slate-100' }}">
                Catalog
            </a>
            <a href="{{ route('public.about') }}"
                class="rounded-full px-3 py-1.5 transition {{ request()->routeIs('public.about') ? 'bg-blue-900 text-white' : 'hover:bg-slate-100' }}">
                About & Contact
            </a>
        </nav>

        <details class="relative md:hidden">
            <summary class="list-none rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-semibold text-slate-700">
                Menu
            </summary>
            <nav class="absolute right-0 mt-2 w-52 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                <a href="{{ route('public.home') }}"
                    class="mb-1 block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('public.home') ? 'bg-blue-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    Home
                </a>
                <a href="{{ route('public.books.index') }}"
                    class="mb-1 block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('public.books.*') ? 'bg-blue-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    Catalog
                </a>
                <a href="{{ route('public.about') }}"
                    class="block rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('public.about') ? 'bg-blue-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    About & Contact
                </a>
            </nav>
        </details>
    </div>
</header>
