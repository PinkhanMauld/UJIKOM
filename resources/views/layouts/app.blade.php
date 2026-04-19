<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen bg-gray-100">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white shadow-md p-5">

        {{-- <h2 class="text-lg font-bold mb-6">
            {{ auth()->user()->name }}
        </h2> --}}
        <br><br>
        <p class="text-sm text-gray-500 mb-4">
            Role: {{ auth()->user()->role }}
        </p>

        <nav class="space-y-2">

            @if(auth()->user()->role === 'admin')

                {{-- <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-gray-100">🏠 Dashboard</a> --}}
                <a href="{{ route('categories.index') }}" class="block p-2 rounded hover:bg-gray-100">🗂 Categories</a>
                <a href="{{ route('items.index') }}" class="block p-2 rounded hover:bg-gray-100">📦 Items</a>
                <a href="{{ route('users.index') }}" class="block p-2 rounded hover:bg-gray-100">👥 Users Admin</a>
                <a href="{{ route('users.operators') }}" class="block p-2 rounded hover:bg-gray-100">👥 Users Operator</a>

            @else

                {{-- <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-gray-100">🏠 Dashboard</a> --}}
                <a href="{{ route('lendings.index') }}" class="block p-2 rounded hover:bg-gray-100">📋 Lendings</a>
                <a href="{{ route('operator.items.index') }}" class="block p-2 rounded hover:bg-gray-100">📦 Items</a>
                <a href="{{ route('operator.users.update') }}" class="block p-2 rounded hover:bg-gray-100">👤 Profil</a>

            @endif

        </nav>

    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col">

        {{-- NAVBAR (optional tetap boleh dipakai) --}}
        @include('layouts.navigation')

        {{-- HEADER --}}
        @isset($header)
            <header class="bg-white shadow">
                <div class="py-4 px-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- CONTENT --}}
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>

    </div>

</div>
    </body>
</html>
