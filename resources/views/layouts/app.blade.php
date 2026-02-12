<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gym Platform') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex flex-col md:flex-row">
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">
                <!-- Top Navigation (Mobile & Desktop Header) -->
                @include('layouts.topbar', ['header' => $header ?? null])

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="px-4 sm:px-6 lg:px-8 mt-6">
                        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-sm flex justify-between items-center" x-data="{ show: true }" x-show="show">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="font-medium">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition">&times;</button>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
