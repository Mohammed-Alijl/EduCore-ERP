{{-- CMS_SECTION: contact | Editable: title, subtitle, address, phone, email, map_url --}}
@props(['cms' => null])

@php
    // Use CMS title/subtitle if available
    $sectionTitle = $cms?->title ?: __('site.contact.get_in');
    $sectionSubtitle = $cms?->subtitle ?: __('site.contact.description');
@endphp

<section id="contact" class="py-24 bg-white relative overflow-hidden">
    <!-- Background Decorations -->
    <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
    <div
        class="absolute top-0 right-0 w-96 h-96 bg-school-100 rounded-full blur-3xl opacity-40 translate-x-1/2 -translate-y-1/2">
    </div>
    <div
        class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-40 -translate-x-1/2 translate-y-1/2">
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div x-data="scrollReveal()" x-intersect.once="reveal()" :class="shown ? 'animate-fade-up' : 'opacity-0'"
            class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-block px-4 py-2 bg-school-100 text-school-600 rounded-full text-sm font-semibold mb-4">
                {{ __('site.contact.title') }}
            </span>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ $sectionTitle }}
                <span class="text-gradient">{{ __('site.contact.touch') }}</span>
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                {{ $sectionSubtitle }}
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <!-- Contact Form -->
            <div x-data="scrollReveal()" x-intersect.once="reveal()"
                :class="shown ? 'animate-fade-right' : 'opacity-0'">
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ __('site.contact.send_message') }}</h3>

                    <form x-data="{
                        form: { name: '', email: '', phone: '', subject: '', message: '' },
                        loading: false,
                        submitted: false,
                        submit() {
                            this.loading = true;
                            setTimeout(() => {
                                this.submitted = true;
                                this.loading = false;
                            }, 1500);
                        }
                    }" @submit.prevent="submit" class="space-y-6">
                        <!-- Name & Email Row -->
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('site.contact.full_name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" x-model="form.name" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-school-500 focus:ring-2 focus:ring-school-500/20 transition-all duration-300 outline-none"
                                    placeholder="{{ __('site.contact.name_placeholder') }}">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('site.contact.email_address') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" x-model="form.email" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-school-500 focus:ring-2 focus:ring-school-500/20 transition-all duration-300 outline-none"
                                    placeholder="{{ __('site.contact.email_placeholder') }}">
                            </div>
                        </div>

                        <!-- Phone & Subject Row -->
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('site.contact.phone_number') }}
                                </label>
                                <input type="tel" id="phone" x-model="form.phone"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-school-500 focus:ring-2 focus:ring-school-500/20 transition-all duration-300 outline-none"
                                    placeholder="{{ __('site.contact.phone_placeholder') }}">
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('site.contact.subject') }} <span class="text-red-500">*</span>
                                </label>
                                <select id="subject" x-model="form.subject" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-school-500 focus:ring-2 focus:ring-school-500/20 transition-all duration-300 outline-none">
                                    <option value="">{{ __('site.contact.select_subject') }}</option>
                                    <option value="admission">{{ __('site.contact.admission_inquiry') }}</option>
                                    <option value="programs">{{ __('site.contact.programs_info') }}</option>
                                    <option value="fees">{{ __('site.contact.fee_structure') }}</option>
                                    <option value="general">{{ __('site.contact.general_inquiry') }}</option>
                                    <option value="other">{{ __('site.contact.other') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('site.contact.message') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" x-model="form.message" required rows="5"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-school-500 focus:ring-2 focus:ring-school-500/20 transition-all duration-300 outline-none resize-none"
                                placeholder="{{ __('site.contact.message_placeholder') }}"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" :disabled="submitted || loading"
                            class="w-full px-8 py-4 bg-gradient-to-r from-school-600 to-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-school-500/25 hover:shadow-xl hover:shadow-school-500/30 transition-all duration-300 hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span x-show="!loading && !submitted">{{ __('site.contact.send_btn') }}</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                {{ __('site.contact.sending') }}
                            </span>
                            <span x-show="submitted" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('site.contact.sent') }}
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info & Map -->
            <div x-data="scrollReveal(200)" x-intersect.once="reveal()" :class="shown ? 'animate-fade-left' : 'opacity-0'"
                class="space-y-8">
                <!-- Contact Info Cards -->
                <div class="grid sm:grid-cols-2 gap-4">
                    <!-- Address -->
                    <div
                        class="bg-gradient-to-br from-school-50 to-indigo-50 rounded-2xl p-6 border border-school-100 group hover:shadow-lg transition-all duration-300">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 text-white flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">{{ __('site.contact.our_address') }}</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ setting('school_address') ?? __('site.contact.default_address') }}
                        </p>
                    </div>

                    <!-- Phone -->
                    <div
                        class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100 group hover:shadow-lg transition-all duration-300">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 text-white flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">{{ __('site.contact.phone_number') }}</h4>
                        <p class="text-gray-600 text-sm">
                            {{ setting('school_phone') ?? __('site.contact.default_phone') }}
                        </p>
                        <p class="text-gray-500 text-xs mt-1">{{ __('site.contact.office_hours_desc') }}</p>
                    </div>

                    <!-- Email -->
                    <div
                        class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-100 group hover:shadow-lg transition-all duration-300">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">{{ __('site.contact.email_address') }}</h4>
                        <p class="text-gray-600 text-sm">
                            {{ setting('school_email') ?? __('site.contact.default_email') }}
                        </p>
                        <p class="text-gray-500 text-xs mt-1">{{ __('site.contact.email_response') }}</p>
                    </div>

                    <!-- Office Hours -->
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100 group hover:shadow-lg transition-all duration-300">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 text-white flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">{{ __('site.contact.office_hours') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __('site.contact.office_hours_full') }}</p>
                        <p class="text-gray-500 text-xs mt-1">{{ __('site.contact.closed_desc') }}</p>
                    </div>
                </div>

                <!-- Map Placeholder / Image -->
                <div class="relative rounded-3xl overflow-hidden shadow-lg border border-gray-200 group">
                    <div class="aspect-[16/10] bg-gradient-to-br from-gray-100 to-gray-200">
                        <!-- Replace with actual map iframe or image -->
                        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=800&auto=format&fit=crop"
                            alt="{{ __('site.contact.map_alt') }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">

                        <!-- Map Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent">
                        </div>

                        <!-- Location Pin -->
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                            <div class="relative">
                                <div class="w-6 h-6 bg-school-500 rounded-full shadow-lg animate-pulse-slow"></div>
                                <div
                                    class="absolute inset-0 w-6 h-6 bg-school-500 rounded-full animate-ping opacity-50">
                                </div>
                            </div>
                        </div>

                        <!-- Get Directions Button -->
                        <a href="#"
                            class="absolute bottom-4 left-4 px-6 py-3 bg-white/90 backdrop-blur-sm rounded-xl font-semibold text-gray-900 shadow-lg hover:bg-white hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5 text-school-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                            {{ __('site.contact.get_directions') }}
                        </a>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="flex items-center justify-center gap-4">
                    <span class="text-gray-500 text-sm">{{ __('site.contact.follow_us') }}</span>
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-school-500 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z">
                                </path>
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-school-500 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z">
                                </path>
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-school-500 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z">
                                </path>
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-school-500 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
