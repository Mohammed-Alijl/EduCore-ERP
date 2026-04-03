{{-- CMS_SECTION: navigation | Editable: logo, links, buttons --}}
<nav x-data="navbar"
    :class="{
        '-translate-y-full': hidden,
        'bg-white/90 shadow-lg backdrop-blur-xl': scrolled,
        'bg-transparent': !scrolled
    }"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo & School Name -->
            <a href="{{ route('landing-page') }}" class="flex items-center gap-3 group">
                @if (setting()->logo_url)
                    <img src="{{ setting()->logo_url }}" alt="{{ setting('school_name') }}"
                        class="h-12 w-12 object-contain transition-transform duration-300 group-hover:scale-110">
                @else
                    <div
                        class="h-12 w-12 bg-gradient-to-br from-school-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                        {{ substr(setting('school_name'), 0, 1) }}
                    </div>
                @endif
                <span :class="scrolled ? 'text-gray-900' : 'text-white'"
                    class="font-bold text-xl hidden sm:block transition-colors duration-300">
                    {{ setting('school_name') }}
                </span>
            </a>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#features"
                    :class="scrolled ? 'text-gray-700 hover:text-school-600' : 'text-white/90 hover:text-white'"
                    class="font-medium transition-colors duration-300">
                    {{ __('site.nav.features') }}
                </a>
                <a href="#stats"
                    :class="scrolled ? 'text-gray-700 hover:text-school-600' : 'text-white/90 hover:text-white'"
                    class="font-medium transition-colors duration-300">
                    {{ __('site.nav.statistics') }}
                </a>
                <a href="#contact"
                    :class="scrolled ? 'text-gray-700 hover:text-school-600' : 'text-white/90 hover:text-white'"
                    class="font-medium transition-colors duration-300">
                    {{ __('site.nav.contact') }}
                </a>
            </div>

            <!-- Login Buttons & Language Switcher -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Language Switcher -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                        :class="scrolled ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-medium transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                            </path>
                        </svg>
                        <span class="uppercase">{{ app()->getLocale() }}</span>
                        <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Language Dropdown -->
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-school-50 hover:text-school-600 transition-colors {{ app()->getLocale() === $localeCode ? 'bg-school-50 text-school-600 font-semibold' : '' }}">
                                {{ $properties['native'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Student Login -->
                <a href="{{ route('login') }}"
                    :class="scrolled ? 'text-school-600 border-school-600 hover:bg-school-50' :
                        'text-white border-white/50 hover:bg-white/10'"
                    class="px-5 py-2.5 border-2 rounded-xl font-semibold transition-all duration-300">
                    {{ __('site.nav.student_login') }}
                </a>

                <!-- Parent Login -->
                <a href="{{ route('login') }}"
                    class="px-5 py-2.5 bg-gradient-to-r from-school-600 to-indigo-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:shadow-school-500/25 transition-all duration-300 hover:-translate-y-0.5">
                    {{ __('site.nav.parent_login') }}
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="toggleMobileMenu" :class="scrolled ? 'text-gray-900' : 'text-white'"
                class="md:hidden p-2 rounded-lg transition-colors duration-300" aria-label="Toggle menu">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" @click.outside="closeMobileMenu"
        class="md:hidden bg-white/95 backdrop-blur-xl border-t border-gray-100">
        <div class="px-4 py-6 space-y-4">
            <a href="#features" @click="closeMobileMenu"
                class="block px-4 py-3 text-gray-700 hover:text-school-600 hover:bg-school-50 rounded-xl font-medium transition-colors">
                {{ __('site.nav.features') }}
            </a>
            <a href="#stats" @click="closeMobileMenu"
                class="block px-4 py-3 text-gray-700 hover:text-school-600 hover:bg-school-50 rounded-xl font-medium transition-colors">
                {{ __('site.nav.statistics') }}
            </a>
            <a href="#contact" @click="closeMobileMenu"
                class="block px-4 py-3 text-gray-700 hover:text-school-600 hover:bg-school-50 rounded-xl font-medium transition-colors">
                {{ __('site.nav.contact') }}
            </a>
            <hr class="border-gray-200">

            <!-- Language Switcher -->
            <div x-data="{ langOpen: false }">
                <button @click="langOpen = !langOpen"
                    class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:text-school-600 hover:bg-school-50 rounded-xl font-medium transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                            </path>
                        </svg>
                        {{ __('site.nav.language') }}
                    </span>
                    <svg class="w-4 h-4" :class="{ 'rotate-180': langOpen }" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>
                <div x-show="langOpen" x-cloak class="mt-2 ml-8 space-y-2">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                            class="block px-4 py-2 text-sm text-gray-600 hover:text-school-600 {{ app()->getLocale() === $localeCode ? 'text-school-600 font-semibold' : '' }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <hr class="border-gray-200">
            <a href="{{ route('login') }}"
                class="block px-4 py-3 text-center text-school-600 border-2 border-school-600 rounded-xl font-semibold hover:bg-school-50 transition-colors">
                {{ __('site.nav.student_login') }}
            </a>
            <a href="{{ route('login') }}"
                class="block px-4 py-3 text-center text-white bg-gradient-to-r from-school-600 to-indigo-600 rounded-xl font-semibold hover:shadow-lg transition-all">
                {{ __('site.nav.parent_login') }}
            </a>
        </div>
    </div>
</nav>
