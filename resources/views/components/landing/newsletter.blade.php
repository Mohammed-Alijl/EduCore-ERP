{{-- CMS_SECTION: newsletter | Editable: title, subtitle, button_text --}}
<section id="newsletter" class="py-16 relative overflow-hidden">
    <!-- Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-r from-school-600 via-indigo-600 to-purple-600"></div>

    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div
            class="absolute bottom-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-float-slow animation-delay-500">
        </div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-pulse-slow">
        </div>

        <!-- Decorative Shapes -->
        <div class="absolute top-10 right-20 w-20 h-20 border-2 border-white/20 rounded-full animate-float-slow"></div>
        <div
            class="absolute bottom-10 left-20 w-16 h-16 border-2 border-white/20 rounded-lg rotate-45 animate-float animation-delay-300">
        </div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div x-data="scrollReveal()" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
            class="text-center">
            <!-- Icon -->
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </div>

            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                {{ __('site.newsletter.title') }}
            </h2>
            <p class="text-xl text-white/80 mb-8 max-w-2xl mx-auto">
                {{ __('site.newsletter.description') }}
            </p>

            <!-- Newsletter Form -->
            <form class="max-w-lg mx-auto" x-data="{ email: '', submitted: false, loading: false }"
                @submit.prevent="loading = true; setTimeout(() => { submitted = true; loading = false; }, 1500)">
                <div class="relative flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="email" x-model="email" required placeholder="{{ __('site.newsletter.email_placeholder') }}"
                            class="w-full px-6 py-4 rounded-xl bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white placeholder-white/60 focus:outline-none focus:border-white focus:bg-white/20 transition-all duration-300">
                        <!-- Success checkmark -->
                        <div x-show="submitted" x-transition
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-green-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <button type="submit" :disabled="submitted || loading"
                        class="px-8 py-4 bg-white text-school-600 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <span x-show="!loading && !submitted">{{ __('site.newsletter.subscribe') }}</span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            {{ __('site.newsletter.subscribing') }}
                        </span>
                        <span x-show="submitted" class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('site.newsletter.subscribed') }}
                        </span>
                    </button>
                </div>
            </form>

            <p class="text-sm text-white/60 mt-4">
                {{ __('site.newsletter.privacy') }}
            </p>
        </div>
    </div>
</section>
