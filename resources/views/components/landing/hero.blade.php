{{-- CMS_SECTION: hero | Editable: title, subtitle, background, cta_buttons --}}
@props(['stats' => [], 'cms' => null])

@php
    // Use CMS data if available, otherwise fall back to translations
    $heroSubtitle = $cms?->subtitle ?: __('site.hero.tagline');
@endphp

<section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Animated Gradient Background -->
    <div class="absolute inset-0 bg-hero-gradient animate-gradient"></div>

    <!-- Decorative Animated Shapes -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating Circles -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div
            class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-float-slow animation-delay-1000">
        </div>
        <div
            class="absolute top-1/2 left-1/3 w-64 h-64 bg-indigo-400/20 rounded-full blur-2xl animate-float-fast animation-delay-500">
        </div>

        <!-- Geometric Shapes -->
        <div class="absolute top-32 right-20 w-20 h-20 border-2 border-white/20 rounded-xl animate-float-slow rotate-12">
        </div>
        <div
            class="absolute bottom-40 left-20 w-16 h-16 border-2 border-white/20 rounded-full animate-float animation-delay-300">
        </div>
        <div class="absolute top-1/2 right-1/4 w-12 h-12 bg-white/10 rounded-lg animate-float-fast rotate-45"></div>

        <!-- Animated Blobs -->
        <div
            class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-purple-400/30 to-pink-400/30 animate-blob blob-shape">
        </div>
        <div
            class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-blue-400/30 to-cyan-400/30 animate-blob animation-delay-1000 blob-shape">
        </div>

        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Logo -->
        <div class="mb-8 animate-scale-up">
            @if (setting()->logo_url)
                <img src="{{ setting()->logo_url }}" alt="{{ setting('school_name') }}"
                    class="h-32 w-32 sm:h-40 sm:w-40 mx-auto object-contain drop-shadow-2xl">
            @else
                <div
                    class="h-32 w-32 sm:h-40 sm:w-40 mx-auto bg-white/20 backdrop-blur-xl rounded-3xl flex items-center justify-center">
                    <span class="text-6xl font-bold text-white">{{ substr(setting('school_name'), 0, 1) }}</span>
                </div>
            @endif
        </div>

        <!-- School Name -->
        <h1
            class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 animate-fade-up animation-delay-200">
            <span class="block drop-shadow-lg">{{ setting('school_name') }}</span>
        </h1>

        <!-- Tagline with Typewriter Effect -->
        <div class="mb-10 animate-fade-up animation-delay-400">
            <p class="text-xl sm:text-2xl md:text-3xl text-white/90 font-light max-w-3xl mx-auto leading-relaxed">
                {{ $heroSubtitle }}
            </p>
            <div class="mt-4 flex items-center justify-center gap-2 text-white/70">
                <span class="w-12 h-px bg-white/50"></span>
                <span class="text-sm font-medium uppercase tracking-widest">{{ __('site.hero.since') }}
                    {{ setting('foundation_year') ?? date('Y') - 20 }}</span>
                <span class="w-12 h-px bg-white/50"></span>
            </div>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-up animation-delay-600">
            <a href="#features"
                class="group px-8 py-4 bg-white text-school-600 rounded-2xl font-bold text-lg shadow-xl hover:shadow-2xl hover:shadow-white/25 transition-all duration-300 hover:-translate-y-1 flex items-center gap-2">
                {{ __('site.hero.explore_features') }}
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
            <a href="#contact"
                class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 rounded-2xl font-bold text-lg hover:bg-white/20 hover:border-white/50 transition-all duration-300 hover:-translate-y-1">
                {{ __('site.hero.contact_us') }}
            </a>
        </div>

        <!-- Quick Stats Preview -->
        <div
            class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-8 max-w-4xl mx-auto animate-fade-up animation-delay-800">
            <div class="glass rounded-2xl p-4 sm:p-6 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-school-600">
                    {{ number_format($stats['students'] ?? 0) }}+</div>
                <div class="text-sm text-gray-600 font-medium">{{ __('site.hero.students') }}</div>
            </div>
            <div class="glass rounded-2xl p-4 sm:p-6 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-school-600">
                    {{ number_format($stats['teachers'] ?? 0) }}+</div>
                <div class="text-sm text-gray-600 font-medium">{{ __('site.hero.teachers') }}</div>
            </div>
            <div class="glass rounded-2xl p-4 sm:p-6 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-school-600">
                    {{ number_format($stats['classrooms'] ?? 0) }}+</div>
                <div class="text-sm text-gray-600 font-medium">{{ __('site.hero.classes') }}</div>
            </div>
            <div class="glass rounded-2xl p-4 sm:p-6 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-school-600">{{ $stats['years'] ?? 20 }}+</div>
                <div class="text-sm text-gray-600 font-medium">{{ __('site.hero.years') }}</div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-scroll">
        <a href="#features" class="flex flex-col items-center gap-2 text-white/70 hover:text-white transition-colors">
            <span class="text-sm font-medium uppercase tracking-widest">{{ __('site.hero.scroll') }}</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
        </a>
    </div>
</section>
