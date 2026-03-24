<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Library Portal' }} | {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Fraunces:opsz,wght@9..144,400;9..144,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --portal-ink: #102a43;
            --portal-surface: #f7f9fc;
            --portal-accent: #004380;
            --portal-accent-dark: #0a5ba8;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--portal-ink);
            background:
                radial-gradient(circle at 10% 15%, #d6e6ff 0%, transparent 36%),
                radial-gradient(circle at 90% 10%, #c9dcff 0%, transparent 30%),
                radial-gradient(circle at 80% 90%, #d9ecff 0%, transparent 26%),
                var(--portal-surface);
        }

        .font-display {
            font-family: 'Fraunces', serif;
        }

        .card-frost {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(16, 42, 67, 0.08);
        }
    </style>
</head>

<body class="min-h-screen antialiased">
    <div class="relative">
        <x-public-portal-nav />

        <main class="mx-auto w-full max-w-6xl px-4 pb-14 pt-8 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        <x-public-portal-footer />
    </div>
</body>

</html>
