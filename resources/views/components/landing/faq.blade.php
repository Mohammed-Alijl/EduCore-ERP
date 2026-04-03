{{-- CMS_SECTION: faq | Editable: title, subtitle, items[] --}}
@props(['faqs' => null])

@php
    $defaultFaqs = [
        [
            'question' => __('site.faq.q1'),
            'answer' => __(
                'site.faq.a1',
            ),
        ],
        [
            'question' => __('site.faq.q2'),
            'answer' => __(
                'site.faq.a2',
            ),
        ],
        [
            'question' => __('site.faq.q3'),
            'answer' => __(
                'site.faq.a3',
            ),
        ],
        [
            'question' => __('site.faq.q4'),
            'answer' => __(
                'site.faq.a4',
            ),
        ],
        [
            'question' => __('site.faq.q5'),
            'answer' => __(
                'site.faq.a5',
            ),
        ],
        [
            'question' => __('site.faq.q6'),
            'answer' => __(
                'site.faq.a6',
            ),
        ],
    ];

    $faqs = $faqs ?? $defaultFaqs;
@endphp

<section id="faq" class="py-24 bg-gray-50 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-dots-pattern opacity-30"></div>
    <div
        class="absolute top-0 left-0 w-96 h-96 bg-school-100 rounded-full blur-3xl opacity-30 -translate-x-1/2 -translate-y-1/2">
    </div>
    <div
        class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-30 translate-x-1/2 translate-y-1/2">
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div x-data="scrollReveal()" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
            class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-school-100 text-school-600 rounded-full text-sm font-semibold mb-4">
                {{ __('site.faq.title') }}
            </span>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ __('site.faq.heading') }}
                <span class="text-gradient">{{ __('site.faq.subheading') }}</span>
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto">
                {{ __('site.faq.description') }}
            </p>
        </div>

        <!-- FAQ Accordion -->
        <div x-data="{ activeIndex: null }" class="space-y-4">
            @foreach ($faqs as $index => $faq)
                <div x-data="scrollReveal({{ $index * 100 }})" x-intersect.once="reveal()"
                    :class="shown ? 'animate-fade-up' : 'opacity-0'">
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-lg"
                        :class="{ 'shadow-lg border-school-200': activeIndex === {{ $index }} }">
                        <!-- Question -->
                        <button @click="activeIndex = activeIndex === {{ $index }} ? null : {{ $index }}"
                            class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 focus:outline-none focus:ring-2 focus:ring-school-500 focus:ring-inset">
                            <h3 class="text-lg font-semibold text-gray-900 pr-8">{{ $faq['question'] }}</h3>
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300"
                                :class="activeIndex === {{ $index }} ? 'bg-school-500 text-white rotate-180' :
                                    'bg-gray-100 text-gray-600'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Answer -->
                        <div x-show="activeIndex === {{ $index }}" x-collapse x-cloak>
                            <div class="px-6 pb-6">
                                <div class="h-px bg-gray-100 mb-4"></div>
                                <p class="text-gray-600 leading-relaxed">{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- CTA -->
        <div x-data="scrollReveal(600)" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
            class="text-center mt-12">
            <p class="text-gray-600 mb-4">{{ __('site.faq.still_questions') }}</p>
            <a href="#contact"
                class="inline-flex items-center gap-2 px-6 py-3 bg-school-600 text-white rounded-xl font-semibold hover:bg-school-700 transition-all duration-300">
                {{ __('site.contact.title') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</section>
