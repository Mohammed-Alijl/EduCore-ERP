{{-- CMS_SECTION: about | Editable: title, subtitle, description, values[] --}}
@props(['values' => null, 'cms' => null])

@php
    // Use CMS title/subtitle if available
    $sectionTitle = $cms?->title ?: __('site.about.heading');
    $sectionSubtitle = $cms?->subtitle ?: __('site.about.description');

    $defaultValues = [
        [
            'icon' =>
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>',
            'title' => __('site.about.innovation'),
            'description' => __('site.about.innovation_desc'),
        ],
        [
            'icon' =>
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>',
            'title' => __('site.about.care'),
            'description' => __('site.about.care_desc'),
        ],
        [
            'icon' =>
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>',
            'title' => __('site.about.excellence'),
            'description' => __('site.about.excellence_desc'),
        ],
        [
            'icon' =>
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
            'title' => __('site.about.community'),
            'description' => __('site.about.community_desc'),
        ],
    ];

    $values = $values ?? $defaultValues;
@endphp

<section id="about" class="py-24 bg-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-school-500 via-indigo-500 to-purple-500"></div>
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-school-100 rounded-full blur-3xl opacity-60"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-100 rounded-full blur-3xl opacity-60"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- Left Content -->
            <div x-data="scrollReveal()" x-intersect.once="reveal()" :class="shown ? 'animate-fade-right' : 'opacity-0'">
                <span
                    class="inline-block px-4 py-2 bg-school-100 text-school-600 rounded-full text-sm font-semibold mb-6">
                    {{ __('site.about.title') }}
                </span>

                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ $sectionTitle }}
                    <span class="text-gradient">{{ __('site.about.subheading') }}</span>
                </h2>

                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    {{ $sectionSubtitle }}
                </p>

                <div class="grid grid-cols-2 gap-6 mb-10">
                    @foreach ($values as $value)
                        <div class="group">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    {!! $value['icon'] !!}
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-1">{{ $value['title'] }}</h3>
                                    <p class="text-sm text-gray-600">{{ $value['description'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <a href="#contact"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-school-600 to-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-school-500/25 hover:shadow-xl hover:shadow-school-500/30 transition-all duration-300 hover:-translate-y-1">
                    {{ __('site.about.learn_more') }}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            <!-- Right Image Grid -->
            <div x-data="scrollReveal(200)" x-intersect.once="reveal()" :class="shown ? 'animate-fade-left' : 'opacity-0'"
                class="relative">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Main Large Image -->
                    <div class="col-span-2 relative group overflow-hidden rounded-3xl">
                        <div class="aspect-[16/9] bg-gradient-to-br from-school-200 to-indigo-200">
                            <img src="{{ asset('assets/site/img/feature-1.jpg') }}"
                                alt="{{ __('site.about.students_in_classroom') }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                        <!-- Overlay Badge -->
                        <div class="absolute bottom-4 left-4 glass rounded-xl px-4 py-2">
                            <span
                                class="text-sm font-semibold text-gray-900">{{ __('site.about.modern_environment') }}</span>
                        </div>
                    </div>

                    <!-- Smaller Images -->
                    <div class="relative group overflow-hidden rounded-2xl">
                        <div class="aspect-square bg-gradient-to-br from-purple-200 to-pink-200">
                            <img src="{{ asset('assets/site/img/feature-2.jpg') }}"
                                alt="{{ __('site.about.students_studying') }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                    </div>

                    <div class="relative group overflow-hidden rounded-2xl">
                        <div class="aspect-square bg-gradient-to-br from-amber-200 to-orange-200">
                            <img src="{{ asset('assets/site/img/feature-3.jpg') }}"
                                alt="{{ __('site.about.school_activities') }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                    </div>
                </div>

                <!-- Floating Achievement Badge -->
                <div
                    class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-2xl p-6 animate-float-slow hidden lg:block">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">A+</div>
                            <div class="text-sm text-gray-600">{{ __('site.about.school_rating') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Decorative Ring -->
                <div
                    class="absolute -top-8 -left-8 w-40 h-40 border-4 border-school-200 rounded-full opacity-60 hidden lg:block">
                </div>
            </div>
        </div>
    </div>
</section>
