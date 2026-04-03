<x-landing.legal-layout :title="__('site.legal.cookie.title')" :subtitle="__('site.legal.cookie.subtitle')" :last-updated="__('site.legal.cookie.last_updated')" :page="$page ?? null">

    <!-- What Are Cookies -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </span>
            {{ __('site.legal.cookie.what_are_cookies.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ __('site.legal.cookie.what_are_cookies.content') }}
            </p>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- Types of Cookies We Use -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.cookie.types_of_cookies.title') }}
        </h2>
        <div class="space-y-8">
            @foreach (__('site.legal.cookie.types_of_cookies.categories') as $category)
                <div
                    class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 rounded-2xl p-6 border border-gray-200 dark:border-gray-600">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-lg bg-school-500 flex items-center justify-center text-white text-sm font-bold">
                            {{ $loop->iteration }}
                        </span>
                        {{ $category['name'] }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ $category['description'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- How We Use Cookies -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.cookie.how_we_use.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                {{ __('site.legal.cookie.how_we_use.content') }}
            </p>
            <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                @foreach (__('site.legal.cookie.how_we_use.items') as $item)
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-school-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- Managing Cookies -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.cookie.managing.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                {{ __('site.legal.cookie.managing.content') }}
            </p>

            <!-- Browser Instructions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 not-prose">
                @foreach (__('site.legal.cookie.managing.browsers') as $browser)
                    <a href="{{ $browser['url'] }}" target="_blank" rel="noopener noreferrer"
                        class="flex items-center gap-4 p-4 bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-school-300 dark:hover:border-school-500 transition-all duration-300 hover:-translate-y-1 group">
                        <div
                            class="w-12 h-12 rounded-lg bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $browser['name'] }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('site.legal.cookie.managing.learn_more') }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-school-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- Third-Party Cookies -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.cookie.third_party.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ __('site.legal.cookie.third_party.content') }}
            </p>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- Contact Information -->
    <div
        class="bg-gradient-to-br from-school-50 to-indigo-50 dark:from-school-900/20 dark:to-indigo-900/20 rounded-2xl p-8 border border-school-200 dark:border-school-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
            <svg class="w-6 h-6 text-school-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
            {{ __('site.legal.cookie.questions.title') }}
        </h2>
        <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
            {{ __('site.legal.cookie.questions.content') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="mailto:{{ setting('school_email') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-school-500 text-white rounded-xl font-semibold hover:bg-school-600 transition-all duration-300 hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                {{ __('site.legal.contact_us') }}
            </a>
            <a href="{{ route('landing-page') }}#contact"
                class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-700 text-school-600 dark:text-school-400 rounded-xl font-semibold border-2 border-school-200 dark:border-school-600 hover:border-school-300 dark:hover:border-school-500 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                {{ __('site.legal.visit_contact_page') }}
            </a>
        </div>
    </div>

</x-landing.legal-layout>
