<header
    class="w-full sticky top-0 z-30 bg-slate-50/80 dark:bg-slate-900/75 backdrop-blur-xl shadow-sm dark:shadow-slate-950/40 border-b border-transparent dark:border-slate-800/80 flex justify-between items-center px-4 md:px-6 h-16">
    <div class="flex items-center gap-3 md:gap-4">
        <!-- Mobile Menu Toggle -->
        <button @click="sidebarOpen = !sidebarOpen"
            class="md:hidden p-2 -ml-2 rounded-full hover:bg-slate-100/50 dark:hover:bg-slate-800 transition-colors text-slate-600 dark:text-slate-300 focus:outline-none">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <h1 class="text-lg md:text-xl font-bold tracking-tight text-slate-900 dark:text-slate-50 font-manrope truncate">
            {{ setting('school_name') }}
        </h1>
    </div>
    <div class="flex items-center gap-2 md:gap-4">
        <div class="relative group hidden md:block">
            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 dark:text-slate-500">
                <span class="material-symbols-outlined text-lg">search</span>
            </span>
            <input
                class="bg-surface-container-high dark:bg-slate-800/90 border-none rounded-full pl-10 pr-4 py-1.5 text-sm text-slate-700 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 w-48 lg:w-64 focus:ring-2 focus:ring-primary/40 transition-all"
                placeholder="Search school records..." type="text" />
        </div>
        <!-- Mobile Search -->
        <button
            class="md:hidden p-2 rounded-full hover:bg-slate-100/50 dark:hover:bg-slate-800 transition-colors relative">
            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">search</span>
        </button>

        <!-- Theme Switcher -->
        <button @click="toggleTheme()"
            :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
            class="inline-flex items-center gap-2 rounded-full border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-800/95 px-2 py-1.5 shadow-sm shadow-slate-200/60 dark:shadow-slate-950/40 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/50"
            type="button">
            <span
                class="relative inline-flex h-6 w-11 items-center rounded-full bg-slate-200 dark:bg-slate-700 transition-colors">
                <span
                    class="inline-block h-5 w-5 transform rounded-full bg-white dark:bg-slate-950 shadow-sm transition-transform"
                    :class="theme === 'dark' ? 'translate-x-5' : 'translate-x-0.5'"></span>
            </span>
            <span class="material-symbols-outlined text-[18px] text-slate-500 dark:text-amber-300"
                x-show="theme === 'light'" x-cloak>dark_mode</span>
            <span class="material-symbols-outlined text-[18px] text-slate-500 dark:text-sky-300"
                x-show="theme === 'dark'" x-cloak>light_mode</span>
        </button>

        <!-- Notifications Dropdown -->
        <div class="relative" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open"
                class="p-2 rounded-full hover:bg-slate-100/50 dark:hover:bg-slate-800 transition-colors relative">
                <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">notifications</span>
                <span class="absolute top-2 right-2 h-2 w-2 bg-error rounded-full"></span>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 overflow-hidden z-50 will-change-transform"
                style="display: none;" x-cloak>
                <div
                    class="p-4 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800 dark:text-slate-200 font-manrope">Notifications</h3>
                    <span class="text-[10px] uppercase font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full">2
                        New</span>
                </div>
                <div class="max-h-80 overflow-y-auto">
                    <!-- Notification Item -->
                    <a href="#"
                        class="block p-4 border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex gap-3">
                            <div
                                class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined text-sm">assignment</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">New Assignment</p>
                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">Mr. Davis posted a new Math
                                    assignment for Julian.</p>
                                <p class="text-[10px] text-slate-400 mt-1">10 mins ago</p>
                            </div>
                        </div>
                    </a>
                    <!-- Notification Item -->
                    <a href="#" class="block p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex gap-3">
                            <div
                                class="h-8 w-8 rounded-full bg-tertiary/10 flex items-center justify-center text-tertiary shrink-0">
                                <span class="material-symbols-outlined text-sm">campaign</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">School Announcement
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">Parent-Teacher meetings are
                                    scheduled for next week.</p>
                                <p class="text-[10px] text-slate-400 mt-1">2 hours ago</p>
                            </div>
                        </div>
                    </a>
                </div>
                <a href="#"
                    class="block w-full p-3 text-center text-xs font-semibold text-primary hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors border-t border-slate-100 dark:border-slate-700">
                    View All Notifications
                </a>
            </div>
        </div>

        <!-- Guardian Profile Dropdown -->
        <div class="relative" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none rounded-full ml-2">
                <div class="h-8 w-8 rounded-full overflow-hidden ring-2 ring-transparent transition-all hover:ring-primary/30"
                    :class="{ 'ring-primary': open }">
                    <img class="h-full w-full object-cover" width="32" height="32" loading="lazy"
                        decoding="async" src="{{ asset('assets/guardian/img/faces/default-avatar.png') }}" />
                </div>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 overflow-hidden z-50 will-change-transform"
                style="display: none;" x-cloak>
                <div
                    class="p-4 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex flex-col items-center text-center">
                    <img class="h-12 w-12 rounded-full object-cover mb-2 ring-2 ring-slate-100 dark:ring-slate-700"
                        width="48" height="48" loading="lazy" decoding="async"
                        src="{{ asset('assets/guardian/img/faces/default-avatar.png') }}" />
                    <p class="font-bold text-sm text-slate-800 dark:text-slate-200">{{auth('guardian')->user()->name_father}}</p>
                    <p class="text-[10px] text-slate-500 uppercase font-semibold mt-0.5">Guardian</p>
                </div>
                <div class="p-2 space-y-1">
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 rounded-xl transition-colors font-medium">
                        <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                        Profile Settings
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 rounded-xl transition-colors font-medium">
                        <span class="material-symbols-outlined text-[20px]">tune</span>
                        Preferences
                    </a>
                </div>
                <div class="p-2 border-t border-slate-100 dark:border-slate-700">
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex items-center gap-3 px-3 py-2 text-sm text-error hover:bg-error/10 hover:text-error rounded-xl transition-colors font-medium">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
