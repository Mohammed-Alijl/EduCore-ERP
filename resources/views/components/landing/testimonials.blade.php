{{-- CMS_SECTION: testimonials | Editable: title, subtitle, items[] --}}
@props(['testimonials' => null, 'cms' => null])

@php
    $locale = app()->getLocale();

    // Use CMS title/subtitle if available
    $sectionTitle = $cms?->title ?: __('site.testimonials.heading');
    $sectionSubtitle = $cms?->subtitle ?: __('site.testimonials.description');

    // Default placeholder images
    $defaultImages = [
        'https://randomuser.me/api/portraits/women/44.jpg',
        'https://randomuser.me/api/portraits/men/32.jpg',
        'https://randomuser.me/api/portraits/women/68.jpg',
        'https://randomuser.me/api/portraits/men/75.jpg',
        'https://randomuser.me/api/portraits/women/89.jpg',
        'https://randomuser.me/api/portraits/men/52.jpg',
    ];

    // Check if CMS has items
    $cmsItems = $cms?->content['items'] ?? null;

    if (!empty($cmsItems)) {
        // Build testimonials from CMS data
        $testimonials = collect($cmsItems)
            ->map(function ($item, $index) use ($locale, $defaultImages) {
                $contentKey = "content_{$locale}";
                $roleKey = "role_{$locale}";
                return [
                    'name' => $item['name'] ?? '',
                    'role' => $item[$roleKey] ?? ($item['role_en'] ?? ''),
                    'image' => $item['image'] ?? ($defaultImages[$index % count($defaultImages)] ?? $defaultImages[0]),
                    'content' => $item[$contentKey] ?? ($item['content_en'] ?? ''),
                    'rating' => (int) ($item['rating'] ?? 5),
                ];
            })
            ->toArray();
    } else {
        // Use default testimonials
        $defaultTestimonials = [
            [
                'name' => 'Sarah Johnson',
                'role' => __('site.testimonials.role1'),
                'image' => $defaultImages[0],
                'content' => __('site.testimonials.content1'),
                'rating' => 5,
            ],
            [
                'name' => 'Michael Chen',
                'role' => __('site.testimonials.role2'),
                'image' => $defaultImages[1],
                'content' => __('site.testimonials.content2'),
                'rating' => 5,
            ],
            [
                'name' => 'Emily Rodriguez',
                'role' => __('site.testimonials.role3'),
                'image' => $defaultImages[2],
                'content' => __('site.testimonials.content3'),
                'rating' => 5,
            ],
            [
                'name' => 'David Thompson',
                'role' => __('site.testimonials.role4'),
                'image' => $defaultImages[3],
                'content' => __('site.testimonials.content4'),
                'rating' => 5,
            ],
            [
                'name' => 'Aisha Patel',
                'role' => __('site.testimonials.role5'),
                'image' => $defaultImages[4],
                'content' => __('site.testimonials.content5'),
                'rating' => 5,
            ],
            [
                'name' => 'James Wilson',
                'role' => __('site.testimonials.role3'),
                'image' => $defaultImages[5],
                'content' => __('site.testimonials.content6'),
                'rating' => 5,
            ],
        ];
        $testimonials = $testimonials ?? $defaultTestimonials;
    }
@endphp

<section id="testimonials" class="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <!-- Decorative Background -->
    <div class="absolute inset-0 bg-dots-pattern opacity-30"></div>
    <div class="absolute top-20 right-20 w-72 h-72 bg-school-100 rounded-full blur-3xl opacity-40"></div>
    <div class="absolute bottom-20 left-20 w-72 h-72 bg-indigo-100 rounded-full blur-3xl opacity-40"></div>

    <!-- Quote Decoration -->
    <div class="absolute top-10 left-10 text-school-100 opacity-50 hidden lg:block">
        <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z">
            </path>
        </svg>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div x-data="scrollReveal()" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
            class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block px-4 py-2 bg-school-100 text-school-600 rounded-full text-sm font-semibold mb-4">
                {{ __('site.testimonials.title') }}
            </span>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ $sectionTitle }}
                <span class="text-gradient">{{ __('site.testimonials.subheading') }}</span>
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                {{ $sectionSubtitle }}
            </p>
        </div>

        <!-- Testimonials Carousel -->
        <div x-data="{
            activeIndex: 0,
            itemsToShow: window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1,
            totalItems: {{ count($testimonials) }},
            get maxIndex() {
                return Math.max(0, this.totalItems - this.itemsToShow);
            },
            init() {
                window.addEventListener('resize', () => {
                    this.itemsToShow = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;
                });
                this.autoplay();
            },
            next() {
                this.activeIndex = this.activeIndex >= this.maxIndex ? 0 : this.activeIndex + 1;
            },
            prev() {
                this.activeIndex = this.activeIndex <= 0 ? this.maxIndex : this.activeIndex - 1;
            },
            autoplay() {
                setInterval(() => this.next(), 5000);
            }
        }" class="relative">
            <!-- Carousel Container -->
            <div class="overflow-hidden rounded-3xl">
                <div class="flex transition-transform duration-500 ease-out"
                    :style="{ transform: `translateX(-${activeIndex * (100 / itemsToShow)}%)` }">
                    @foreach ($testimonials as $index => $testimonial)
                        <div class="w-full lg:w-1/3 md:w-1/2 flex-shrink-0 px-3">
                            <div
                                class="h-full bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                                <!-- Rating Stars -->
                                <div class="flex gap-1 mb-6">
                                    @for ($i = 0; $i < $testimonial['rating']; $i++)
                                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    @endfor
                                </div>

                                <!-- Content -->
                                <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                                    "{{ $testimonial['content'] }}"
                                </p>

                                <!-- Author -->
                                <div class="flex items-center gap-4 mt-auto">
                                    <img src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] }}"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-school-100">
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $testimonial['name'] }}</h4>
                                        <p class="text-sm text-gray-500">{{ $testimonial['role'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-center items-center gap-4 mt-10">
                <button @click="prev"
                    class="p-3 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-school-50 hover:border-school-300 hover:text-school-600 transition-all duration-300 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>

                <!-- Dots -->
                <div class="flex gap-2">
                    <template x-for="i in (maxIndex + 1)" :key="i">
                        <button @click="activeIndex = i - 1"
                            :class="activeIndex === i - 1 ? 'bg-school-600 w-8' : 'bg-gray-300 w-2'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    </template>
                </div>

                <button @click="next"
                    class="p-3 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-school-50 hover:border-school-300 hover:text-school-600 transition-all duration-300 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
