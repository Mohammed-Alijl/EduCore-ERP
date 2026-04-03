<x-landing.legal-layout :title="__('site.legal.privacy.title')" :subtitle="__('site.legal.privacy.subtitle')" :last-updated="__('site.legal.privacy.last_updated')">

    <!-- Introduction -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </span>
            {{ __('site.legal.privacy.introduction.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ __('site.legal.privacy.introduction.content') }}
            </p>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- Information We Collect -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.privacy.information_collection.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                {{ __('site.legal.privacy.information_collection.content') }}
            </p>
            <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                @foreach (__('site.legal.privacy.information_collection.items') as $item)
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

    <!-- How We Use Your Information -->
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
            {{ __('site.legal.privacy.information_use.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                {{ __('site.legal.privacy.information_use.content') }}
            </p>
            <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                @foreach (__('site.legal.privacy.information_use.items') as $item)
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

    <!-- Data Security -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.privacy.data_security.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ __('site.legal.privacy.data_security.content') }}
            </p>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- Your Rights -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.privacy.your_rights.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                {{ __('site.legal.privacy.your_rights.content') }}
            </p>
            <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                @foreach (__('site.legal.privacy.your_rights.items') as $item)
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

    <!-- Contact Information -->
    <div
        class="bg-gradient-to-br from-school-50 to-indigo-50 dark:from-school-900/20 dark:to-indigo-900/20 rounded-2xl p-8 border border-school-200 dark:border-school-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
            <svg class="w-6 h-6 text-school-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
            {{ __('site.legal.privacy.contact.title') }}
        </h2>
        <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
            {{ __('site.legal.privacy.contact.content') }}
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
