{{-- CMS_SECTION: statistics | Editable: stats[] --}}
@props(['stats' => [], 'cms' => null])

@php
    // Use CMS title/subtitle if available
    $sectionTitle = $cms?->title ?: __('site.stats.our');
    $sectionSubtitle = $cms?->subtitle ?: __('site.stats.description');

    $defaultStats = [
        [
            'value' => $stats['students'] ?? 100,
            'suffix' => '+',
            'label' => __('site.stats.students_enrolled'),
            'icon' =>
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
        ],
        [
            'value' => $stats['teachers'] ?? 0,
            'suffix' => '+',
            'label' => __('site.stats.expert_teachers'),
            'icon' =>
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>',
        ],
        [
            'value' => $stats['classrooms'] ?? 0,
            'suffix' => '+',
            'label' => __('site.stats.active_classes'),
            'icon' =>
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
        ],
        [
            'value' => $stats['years'] ?? 20,
            'suffix' => '+',
            'label' => __('site.stats.years_of_excellence'),
            'icon' =>
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>',
        ],
    ];

    $statsData = $defaultStats;
@endphp

<section id="stats" class="py-24 relative overflow-hidden">
    <!-- Dark Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-school-900 to-indigo-900"></div>

    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 w-64 h-64 bg-school-500/10 rounded-full blur-3xl animate-float"></div>
        <div
            class="absolute bottom-20 right-20 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl animate-float-slow animation-delay-500">
        </div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl animate-pulse-slow">
        </div>

        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div x-data="scrollReveal()" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
            class="text-center max-w-3xl mx-auto mb-16">
            <span
                class="inline-block px-4 py-2 bg-white/10 text-white rounded-full text-sm font-semibold mb-4 backdrop-blur-sm">
                {{ __('site.stats.by_the_numbers') }}
            </span>
            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                {{ $sectionTitle }}
                <span class="text-gradient-gold">{{ __('site.stats.achievements') }}</span>
            </h2>
            <p class="text-xl text-gray-300 leading-relaxed">
                {{ $sectionSubtitle }}
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @foreach ($statsData as $index => $stat)
                <div x-data="statCounter({{ $stat['value'] }}, '{{ $stat['suffix'] }}', {{ $index * 150 }})" x-intersect.once="reveal(); animateCount()"
                    :class="shown ? 'animate-fade-up' : 'opacity-0'" class="group">
                    <div
                        class="relative bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                        <!-- Glow Effect on Hover -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-school-500/0 to-indigo-500/0 group-hover:from-school-500/10 group-hover:to-indigo-500/10 transition-all duration-500">
                        </div>

                        <div class="relative z-10">
                            <!-- Icon -->
                            <div
                                class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 text-white mb-4 group-hover:scale-110 transition-transform duration-300">
                                {!! $stat['icon'] !!}
                            </div>

                            <!-- Number with Count Animation -->
                            <div class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-2">
                                <span x-text="displayValue">0</span>
                            </div>

                            <!-- Label -->
                            <p class="text-gray-400 font-medium group-hover:text-gray-300 transition-colors">
                                {{ $stat['label'] }}
                            </p>
                        </div>

                        <!-- Decorative Corner -->
                        <div
                            class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-school-500/20 to-transparent rounded-bl-3xl">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Additional Info -->
        <div x-data="scrollReveal(600)" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
            class="mt-16 text-center">
            <p class="text-gray-400 max-w-2xl mx-auto">
                {{ __('site.stats.join_us') }}
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#contact"
                    class="px-8 py-4 bg-gradient-to-r from-school-500 to-indigo-500 text-white rounded-2xl font-bold text-lg shadow-lg shadow-school-500/25 hover:shadow-xl hover:shadow-school-500/30 transition-all duration-300 hover:-translate-y-1">
                    {{ __('site.stats.start_journey') }}
                </a>
                <a href="#features"
                    class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white border border-white/20 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all duration-300">
                    {{ __('site.stats.learn_more') }}
                </a>
            </div>
        </div>
    </div>
</section>
