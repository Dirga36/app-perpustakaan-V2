@extends('layouts.focus')

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-5">
                <div
                    class="block p-6 bg-white border border-gray-200 rounded-lg shadow-xs dark:bg-gray-800 dark:border-gray-700">
                    <a data-tooltip-target="tooltip-default" href="{{ route('discover') }}"
                        class="inline-flex items-center text-blue-600 hover:underline text-sm font-medium">
                        🡨 Back
                    </a>
                    <div id="tooltip-default" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                        Back to discover
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $post->title }}
                    </h5>
                    @if (Auth::check() && Auth::user()->id == $post->user_id)
                        <p class="italic text-gray-500">You</p>
                    @else
                        <p class="text-gray-500">{{ $post->user->name }}</p>
                    @endif
                    <p class="mt-3">{{ $post->created_at->diffForHumans() }}</p>
                    <span
                        class="text-lg bg-blue-100 text-blue-800 font-medium me-2 px-2.5 py-0.5 rounded-xs dark:bg-blue-900 dark:text-blue-300">
                        {{ $post->category->name }}
                    </span>
                    @if ($post->thumbnail)
                        <div class="basis-1/4 p-0 content-center justify-center my-5">
                            <img src="{{ asset('thumbnails/' . $post->thumbnail . '.jpg') }}" alt="{{ $post->title }}"
                                class="rounded-md object-cover w-full h-fit">
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

                    <p class="font-normal text-gray-700 dark:text-gray-400 mb-5">
                        {!! $post->content !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
