{{-- CMS_SECTION: programs | Editable: title, subtitle, items[] --}}
@props(['grades' => null, 'cms' => null])

@php
    // Use CMS title/subtitle if available
    $sectionTitle = $cms?->title ?: __('site.programs.academic');
    $sectionSubtitle = $cms?->subtitle ?: __('site.programs.description');

    // Default fallback images if grades don't have images
$defaultImages = [
    asset('assets/site/img/grades/grade-1.jpg'),
    asset('assets/site/img/grades/grade-2.jpg'),
    asset('assets/site/img/grades/grade-3.jpg'),
    asset('assets/site/img/grades/grade-4.jpg'),
    asset('assets/site/img/grades/grade-5.jpg'),
    asset('assets/site/img/grades/grade-6.jpg'),
];

$gradientColors = [
    'from-blue-500 to-cyan-500',
    'from-purple-500 to-pink-500',
    'from-amber-500 to-orange-500',
    'from-green-500 to-emerald-500',
    'from-rose-500 to-red-500',
    'from-indigo-500 to-blue-500',
    ];

    // If grades passed, use them; otherwise use empty array
    $grades = $grades ?? collect([]);
@endphp

<section id="programs" class="py-24 bg-white relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div x-data="scrollReveal()" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
            class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block px-4 py-2 bg-school-100 text-school-600 rounded-full text-sm font-semibold mb-4">
                {{ __('site.programs.title') }}
            </span>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ $sectionTitle }}
                <span class="text-gradient">{{ __('site.features.excellence') }}</span>
                {{ __('site.programs.for_every_student') }}
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                {{ $sectionSubtitle }}
            </p>
        </div>

        <!-- Programs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($grades as $index => $grade)
                @php
                    $gradeImage = $grade->image
                        ? asset('storage/' . $grade->image)
                        : $defaultImages[$index % count($defaultImages)];
                    $gradeColor = $gradientColors[$index % count($gradientColors)];
                    $studentCount = $grade->students()->count();
                @endphp

                <div x-data="scrollReveal({{ $index * 100 }})" x-intersect.once="reveal()"
                    :class="shown ? 'animate-fade-up' : 'opacity-0'" class="group">
                    <div
                        class="relative h-full bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100">
                        <!-- Image -->
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $gradeImage }}" alt="{{ $grade->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                            <!-- Gradient Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>

                            <!-- Grade Badge -->
                            <div
                                class="absolute top-4 left-4 px-4 py-2 rounded-full bg-white/90 backdrop-blur-sm text-sm font-semibold text-gray-900">
                                {{ $grade->name }}
                            </div>

                            <!-- Color Accent Bar -->
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r {{ $gradeColor }}">
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3
                                class="text-xl font-bold text-gray-900 mb-3 group-hover:text-school-600 transition-colors">
                                {{ $grade->name }}
                            </h3>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                @if ($grade->notes)
                                    {{ Str::limit($grade->notes, 120) }}
                                @else
                                    {{ __('site.programs.default_desc') }}
                                @endif
                            </p>

                            <!-- Stats -->
                            <div class="flex items-center gap-4 mb-4 text-sm text-gray-500">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <span>{{ $studentCount }} {{ __('site.hero.students') }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    <span>{{ $grade->classrooms()->count() }} {{ __('site.hero.classes') }}</span>
                                </div>
                            </div>

                            <!-- Learn More Link -->
                            <a href="#contact"
                                class="inline-flex items-center text-school-600 font-semibold hover:text-school-700 transition-colors group/link">
                                {{ __('site.stats.learn_more') }}
                                <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-2 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                    <p class="text-gray-500 text-lg">{{ __('site.programs.no_grades') }}</p>
                </div>
            @endforelse
        </div>

        <!-- View All Button -->
        <div x-data="scrollReveal(600)" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
            class="text-center mt-12">
            <a href="#contact"
                class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 text-white rounded-2xl font-bold hover:bg-gray-800 transition-all duration-300 hover:-translate-y-1 shadow-lg">
                {{ __('site.programs.view_all') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</section>
