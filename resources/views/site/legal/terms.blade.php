<x-landing.legal-layout :title="__('site.legal.terms.title')" :subtitle="__('site.legal.terms.subtitle')" :last-updated="__('site.legal.terms.last_updated')" :page="$page ?? null">

    <!-- Acceptance of Terms -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </span>
            {{ __('site.legal.terms.acceptance.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ __('site.legal.terms.acceptance.content') }}
            </p>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- User Accounts -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </span>
            {{ __('site.legal.terms.user_accounts.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                {{ __('site.legal.terms.user_accounts.content') }}
            </p>
            <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                @foreach (__('site.legal.terms.user_accounts.items') as $item)
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

    <!-- Educational Services -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.terms.educational_services.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ __('site.legal.terms.educational_services.content') }}
            </p>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- User Conduct -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.terms.user_conduct.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                {{ __('site.legal.terms.user_conduct.content') }}
            </p>
            <ul class="space-y-3 text-gray-600 dark:text-gray-300">
                @foreach (__('site.legal.terms.user_conduct.items') as $item)
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
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

    <!-- Intellectual Property -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.terms.intellectual_property.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ __('site.legal.terms.intellectual_property.content') }}
            </p>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- Limitation of Liability -->
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
            {{ __('site.legal.terms.limitation_liability.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ __('site.legal.terms.limitation_liability.content') }}
            </p>
        </div>
    </div>

    <!-- Divider -->
    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent my-12"></div>

    <!-- Termination -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-school-500 to-indigo-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                    </path>
                </svg>
            </span>
            {{ __('site.legal.terms.termination.title') }}
        </h2>
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ __('site.legal.terms.termination.content') }}
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
            {{ __('site.legal.terms.questions.title') }}
        </h2>
        <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
            {{ __('site.legal.terms.questions.content') }}
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
