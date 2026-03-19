@extends('layouts.focus')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col">

        {{-- Navbar --}}
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
                <a href={{ route('welcome') }}>
                    <x-application-logo />
                </a>
                <div class="flex items-center space-x-8">
                    <a href="#about" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Tentang</a>
                    <a href="#features" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Fitur</a>
                    <a href="#contact" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Kontak</a>
                </div>
                <nav class="space-x-4">
                    @auth
                        <a href="{{ url('/filament.admin.pages.dashboard') }}" class="text-primary hover:text-blue-800">Admin Dashboard</a>
                    @else
                        <a href="{{ route('filament.admin.auth.login') }}" class="text-gray-700 hover:text-primary" title="Admin Login"><x-heroicon-s-user-circle class="w-6 h-6 text-gray-500"/></a>
                    @endauth
                </nav>
            </div>
        </header>

        <footer class="bg-gray-100 dark:bg-gray-800 py-6">
            <div class="max-w-7xl mx-auto px-6 text-center text-sm text-gray-600 dark:text-gray-400">
                © {{ date('Y') }} Project library VI. All rights reserved.
            </div>
        </footer>
    @endsection
