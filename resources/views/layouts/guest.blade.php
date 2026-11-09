<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PerpustakaanKu') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8">

        <a href="{{ url('/') }}" class="logo mb-6">
            <span class="logo-icon">📚</span>
            <span>PerpustakaanKu</span>
        </a>

        <div class="w-full sm:max-w-md bg-white shadow-lg rounded-xl p-6">
            {{ $slot }}
        </div>

        <p class="mt-6 text-sm text-center" style="color: var(--muted)">
            © 2026 PerpustakaanKu
        </p>

    </div>
</body>
</html>
