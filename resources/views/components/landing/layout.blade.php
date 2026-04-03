<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ setting('school_name') }} - Excellence in Education">
    <meta name="keywords" content="school, education, learning, students, teachers">

    <title>{{ setting('school_name') }}</title>

    <!-- Favicon -->
    @if (setting()->logo_url)
        <link rel="icon" type="image/png" href="{{ setting()->logo_url }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/landing.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-white text-gray-900 overflow-x-hidden">
    <!-- Scroll Progress Bar -->
    <div x-data="scrollProgress" class="scroll-progress" :style="{ width: progress + '%' }"></div>

    {{ $slot }}

    <!-- Back to Top Button -->
    <button x-data="backToTop" x-show="visible" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" @click="scrollToTop"
        class="fixed bottom-8 right-8 z-50 p-3 bg-school-600 text-white rounded-full shadow-lg hover:bg-school-700 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-school-500 focus:ring-offset-2"
        aria-label="Back to top">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>
</body>

</html>
