@extends('layouts.focus')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col space-y-10">

        {{-- Navbar --}}
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <a href={{ route('welcome') }}>
                    <x-application-logo />
                </a>
                <nav class="space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-3 text-gray-700 hover:text-blue-600">Register</a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-5">
                @foreach ($posts as $post)
                    <a href={{ route('posts.show', $post->id) }}
                        class="block p-6 bg-white border border-gray-200 rounded-lg shadow-xs hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                        @if (Auth::check() && Auth::user()->id == $post->user_id)
                            <p class="italic text-gray-500">You - {{ $post->created_at->diffForHumans() }}</p>
                        @else
                            <p class="text-gray-500">{{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}
                            </p>
                        @endif

                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $post->title }}</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400 mb-5">
                            {!! Str::limit($post->content, 150) !!}</p>
                        @if ($post->thumbnail)
                            <div class="basis-1/4 p-0 content-center justify-center">
                                <img src="{{ asset('thumbnails/' . $post->thumbnail . '.jpg') }}"
                                    alt="{{ $post->title }}" class="rounded-md object-cover w-full h-fit">
                            </div>
                        @endif
                        {{-- 
                                        ----------------Via stoarge--------------:

                                        @if ($post->thumbnail)
                                            <img src="{{ asset('storage/' . $post->thumbnail) }}"
                                                alt="{{ $post->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs">
                                                No image
                                            </div>
                                        @endif --}}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
