{{-- CMS_SECTION: legal_page | Editable: title, subtitle, last_updated, sections[] --}}
@props(['title', 'subtitle', 'lastUpdated'])

<x-landing.layout>
    <!-- Hero Section -->
    <section class="relative min-h-[40vh] flex items-center justify-center overflow-hidden">
        <!-- Dark Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-school-900 to-indigo-900"></div>

        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-20 w-96 h-96 bg-school-500/10 rounded-full blur-3xl animate-float"></div>
            <div
                class="absolute bottom-20 right-20 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl animate-float-slow animation-delay-500">
            </div>
            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <!-- Breadcrumb -->
            <nav x-data="scrollReveal()" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
                class="flex items-center justify-center gap-2 text-sm mb-8">
                <a href="{{ route('landing-page') }}"
                    class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    {{ __('site.nav.home') }}
                </a>
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-school-400">{{ $title }}</span>
            </nav>

            <!-- Title -->
            <div x-data="scrollReveal(100)" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                    {{ $title }}
                </h1>
                <p class="text-xl text-gray-300 leading-relaxed max-w-2xl mx-auto mb-8">
                    {{ $subtitle }}
                </p>

                <!-- Last Updated Badge -->
                @if ($lastUpdated)
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20">
                        <svg class="w-4 h-4 text-school-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-gray-300">
                            {{ __('site.legal.last_updated') }}: <span
                                class="text-white font-medium">{{ $lastUpdated }}</span>
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Decorative Bottom Wave -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-16 text-gray-50 dark:text-gray-900" preserveAspectRatio="none" viewBox="0 0 1200 120"
                fill="currentColor">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- Main Content -->
    <section class="relative py-24 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Content Card -->
            <div x-data="scrollReveal()" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 lg:p-12 border border-gray-200 dark:border-gray-700">
                {{ $slot }}
            </div>

            <!-- Back to Home CTA -->
            <div x-data="scrollReveal(200)" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
                class="mt-12 text-center">
                <a href="{{ route('landing-page') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-school-500 to-indigo-500 text-white rounded-2xl font-bold text-lg shadow-lg shadow-school-500/25 hover:shadow-xl hover:shadow-school-500/30 transition-all duration-300 hover:-translate-y-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                    {{ __('site.legal.back_to_home') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-landing.footer />
</x-landing.layout>
