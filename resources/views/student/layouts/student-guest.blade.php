<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Student Portal') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding Panel -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 relative overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 opacity-10">
                <img src="{{ asset('assets/student/img/auth/login.png') }}" alt="Background"
                    class="w-full h-full object-cover">
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-between p-12 w-full text-white">
                <!-- Logo & Brand -->
                <div>
                    <div class="flex items-center gap-3 mb-16">
                        <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold">{{ config('app.name', 'School') }}</span>
                    </div>

                    <div class="max-w-md">
                        <h1 class="text-4xl font-bold leading-tight mb-6">
                            Excellence in every interaction.
                        </h1>
                        <p class="text-lg text-blue-100 leading-relaxed">
                            Access your personalized learning ecosystem, financial summaries, and academic trajectory in one unified dashboard.
                        </p>
                    </div>
                </div>

                <!-- Social Proof -->
                <div class="flex items-center gap-3">
                    <div class="flex -space-x-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-400 border-2 border-blue-900 flex items-center justify-center text-xs font-bold">
                            JS
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 border-2 border-blue-900 flex items-center justify-center text-xs font-bold">
                            AK
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-teal-400 border-2 border-blue-900 flex items-center justify-center text-xs font-bold">
                            LM
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-red-400 border-2 border-blue-900 flex items-center justify-center text-xs font-bold">
                            +9K
                        </div>
                    </div>
                    <p class="text-sm text-blue-200 font-medium tracking-wide">
                        JOINED BY 12K+ SCHOLARS
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-gray-50">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-900 to-indigo-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">{{ config('app.name', 'School') }}</span>
                    </div>
                </div>

                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
