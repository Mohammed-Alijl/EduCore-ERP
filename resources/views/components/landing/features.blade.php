{{-- CMS_SECTION: features | Editable: title, subtitle, items[] --}}
@props(['features' => null, 'cms' => null])

@php
    $locale = app()->getLocale();
    $defaultGradients = [
        'from-blue-500 to-cyan-500',
        'from-purple-500 to-pink-500',
        'from-green-500 to-emerald-500',
        'from-orange-500 to-amber-500',
        'from-indigo-500 to-blue-500',
        'from-rose-500 to-red-500',
    ];

    $defaultIcons = [
        '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
        '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>',
        '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
        '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>',
        '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
        '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
    ];

    // Use CMS title/subtitle if available
    $sectionTitle = $cms?->title ?: __('site.features.everything_you_need');
    $sectionSubtitle = $cms?->subtitle ?: __('site.features.description');

    // Check if CMS has items
    $cmsItems = $cms?->content['items'] ?? null;

    if (!empty($cmsItems)) {
        // Build features from CMS data
        $features = collect($cmsItems)
            ->map(function ($item, $index) use ($defaultGradients, $defaultIcons, $locale) {
                $titleKey = "title_{$locale}";
                $descKey = "desc_{$locale}";
                return [
                    'icon' => !empty($item['icon'])
                        ? "<i class=\"{$item['icon']} text-3xl\"></i>"
                        : $defaultIcons[$index % count($defaultIcons)] ?? $defaultIcons[0],
                    'title' => $item[$titleKey] ?? ($item['title_en'] ?? ''),
                    'description' => $item[$descKey] ?? ($item['desc_en'] ?? ''),
                    'gradient' => $defaultGradients[$index % count($defaultGradients)],
                ];
            })
            ->toArray();
    } else {
        // Use default features
        $defaultFeatures = [
            [
                'icon' => $defaultIcons[0],
                'title' => __('site.features.student_management'),
                'description' => __('site.features.student_management_desc'),
                'gradient' => 'from-blue-500 to-cyan-500',
            ],
            [
                'icon' => $defaultIcons[1],
                'title' => __('site.features.academic_excellence'),
                'description' => __('site.features.academic_excellence_desc'),
                'gradient' => 'from-purple-500 to-pink-500',
            ],
            [
                'icon' => $defaultIcons[2],
                'title' => __('site.features.online_learning'),
                'description' => __('site.features.online_learning_desc'),
                'gradient' => 'from-green-500 to-emerald-500',
            ],
            [
                'icon' => $defaultIcons[3],
                'title' => __('site.features.library_resources'),
                'description' => __('site.features.library_resources_desc'),
                'gradient' => 'from-orange-500 to-amber-500',
            ],
            [
                'icon' => $defaultIcons[4],
                'title' => __('site.features.finance_management'),
                'description' => __('site.features.finance_management_desc'),
                'gradient' => 'from-indigo-500 to-blue-500',
            ],
            [
                'icon' => $defaultIcons[5],
                'title' => __('site.features.smart_scheduling'),
                'description' => __('site.features.smart_scheduling_desc'),
                'gradient' => 'from-rose-500 to-red-500',
            ],
        ];
        $features = $features ?? $defaultFeatures;
    }
@endphp

<section id="features" class="py-24 bg-gray-50 relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 bg-dots-pattern opacity-50"></div>
    <div
        class="absolute top-0 right-0 w-96 h-96 bg-school-100 rounded-full blur-3xl opacity-50 -translate-y-1/2 translate-x-1/2">
    </div>
    <div
        class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-50 translate-y-1/2 -translate-x-1/2">
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div x-data="scrollReveal()" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
            class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block px-4 py-2 bg-school-100 text-school-600 rounded-full text-sm font-semibold mb-4">
                {{ __('site.features.our_features') }}
            </span>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ $sectionTitle }}
                <span class="text-gradient">{{ __('site.features.excellence') }}</span>
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                {{ $sectionSubtitle }}
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($features as $index => $feature)
                <div x-data="scrollReveal({{ $index * 100 }})" x-intersect.once="reveal()"
                    :class="shown ? 'animate-fade-up' : 'opacity-0'" class="group">
                    <div
                        class="h-full bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 border border-gray-100">
                        <!-- Icon -->
                        <div class="mb-6">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br {{ $feature['gradient'] }} text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                                {!! $feature['icon'] !!}
                            </div>
                        </div>

                        <!-- Content -->
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-school-600 transition-colors">
                            {{ $feature['title'] }}
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $feature['description'] }}
                        </p>

                        <!-- Hover Accent -->
                        <div
                            class="mt-6 flex items-center text-school-600 font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span>{{ __('site.features.learn_more') }}</span>
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
