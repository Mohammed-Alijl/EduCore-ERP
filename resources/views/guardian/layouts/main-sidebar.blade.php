<!-- Mobile overlay -->
<div x-show="sidebarOpen"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden"
     style="display: none;" x-cloak></div>

<aside
    class="h-screen w-64 fixed left-0 top-0 z-50 bg-[#001a42] dark:bg-slate-950 flex flex-col py-6 gap-2 font-inter body-md tracking-wide transform transition-transform duration-300 ease-in-out md:translate-x-0 -translate-x-full"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <!-- Mobile Close Button -->
    <button @click="sidebarOpen = false" class="md:hidden absolute top-4 right-4 p-2 rounded-full hover:bg-white/10 text-slate-300 transition-colors">
        <span class="material-symbols-outlined">close</span>
    </button>

    <div class="px-6 mb-8 relative" x-data="{ open: false }" @click.away="open = false">
        <div @click="open = !open"
            class="flex items-center gap-3 glass-switcher p-2 rounded-xl shadow-sm cursor-pointer border border-transparent transition-all"
            :class="{ 'ring-2 ring-primary/50 border-primary/20': open, 'hover:bg-white/90': !open }">
            <div class="h-10 w-10 rounded-full overflow-hidden bg-surface-container-highest ring-2 ring-primary">
                <img class="h-full w-full object-cover" width="40" height="40" loading="lazy" decoding="async" data-alt="Student portrait"
                    src="{{ asset('assets/guardian/img/faces/default-avatar.png') }}" />
            </div>
            <div>
                <p class="text-xs font-bold text-on-primary-fixed uppercase tracking-tighter">Julian Anderson</p>
                <p class="text-[10px] text-slate-500 font-medium">Grade 10-B</p>
            </div>
            <span class="material-symbols-outlined text-slate-400 ml-auto text-sm transition-transform duration-200"
                :class="{ 'rotate-180': open }">unfold_more</span>
        </div>

        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95 translate-y-[-10px]"
            x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="transform opacity-0 scale-95 translate-y-[-10px]"
            class="absolute left-6 right-6 top-[4.5rem] mt-2 bg-white dark:bg-slate-800 rounded-xl shadow-xl shadow-blue-900/10 border border-slate-100 dark:border-slate-700 overflow-hidden z-50 will-change-transform"
            style="display: none;" x-cloak>

            <div class="px-3 py-2 bg-slate-50/50 dark:bg-slate-800/80 border-b border-slate-100 dark:border-slate-700">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Select Student</p>
            </div>

            <div class="p-1 max-h-60 overflow-y-auto">
                <!-- Active Student -->
                <button
                    class="w-full flex items-center gap-3 p-2 rounded-lg bg-primary/5 text-left transition-colors relative">
                    <div class="h-8 w-8 rounded-full overflow-hidden shrink-0 ring-1 ring-primary">
                        <img class="h-full w-full object-cover" width="32" height="32" loading="lazy" decoding="async"
                            src="{{ asset('assets/guardian/img/faces/default-avatar.png') }}" />
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-primary">Julian Anderson</p>
                        <p class="text-[9px] text-slate-500 font-medium">Grade 10-B</p>
                    </div>
                    <span class="material-symbols-outlined text-sm text-primary">check_circle</span>
                </button>

                <!-- Inactive Student 1 -->
                <button
                    class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700/50 text-left transition-colors">
                    <div class="h-8 w-8 rounded-full overflow-hidden shrink-0 ring-1 ring-slate-200">
                        <img class="h-full w-full object-cover" width="32" height="32" loading="lazy" decoding="async"
                            src="{{ asset('assets/guardian/img/faces/default-avatar.png') }}" />
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Maya Anderson</p>
                        <p class="text-[9px] text-slate-500 font-medium">Grade 7-A</p>
                    </div>
                </button>

                <!-- Inactive Student 2 -->
                <button
                    class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700/50 text-left transition-colors">
                    <div class="h-8 w-8 rounded-full overflow-hidden shrink-0 ring-1 ring-slate-200">
                        <img class="h-full w-full object-cover" width="32" height="32" loading="lazy" decoding="async"
                            src="{{ asset('assets/guardian/img/faces/default-avatar.png') }}" />
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Leo Anderson</p>
                        <p class="text-[9px] text-slate-500 font-medium">Grade 3-C</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <nav class="flex-1 space-y-1 px-4">
        <a href="{{ route('guardian.dashboard') }}"
            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('guardian.dashboard') ? 'bg-primary-container text-white shadow-lg shadow-blue-900/40 translate-x-1' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('guardian.dashboard') ? 'material-filled' : '' }}">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a class="w-full flex items-center gap-3 text-slate-300 px-4 py-3 hover:text-white hover:bg-white/10 rounded-xl transition-all"
            href="#">
            <span class="material-symbols-outlined">school</span>
            <span>Academics</span>
        </a>
        <a class="w-full flex items-center gap-3 text-slate-300 px-4 py-3 hover:text-white hover:bg-white/10 rounded-xl transition-all"
            href="#">
            <span class="material-symbols-outlined">payments</span>
            <span>Finance</span>
        </a>
        <a class="w-full flex items-center gap-3 text-slate-300 px-4 py-3 hover:text-white hover:bg-white/10 rounded-xl transition-all"
            href="#">
            <span class="material-symbols-outlined">chat_bubble</span>
            <span>Communication</span>
        </a>
    </nav>

    <div class="mt-auto px-4 pb-4">
        <button
            class="w-full bg-primary-container text-white py-3 rounded-xl font-semibold text-sm shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2 transition-transform hover:scale-[1.02]">
            Academic Portfolio
        </button>
    </div>

    <div class="border-t border-white/10 pt-4 space-y-1">
        <a class="flex items-center gap-3 text-slate-300 px-4 py-2 mx-2 hover:text-white hover:bg-white/10 rounded-full transition-all text-sm"
            href="#">
            <span class="material-symbols-outlined text-base">help</span>
            <span>Help Center</span>
        </a>
        <!-- Ensure proper logout form mapping in the future -->
        <a class="flex items-center gap-3 text-slate-300 px-4 py-2 mx-2 hover:text-white hover:bg-white/10 rounded-full transition-all text-sm"
            href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-symbols-outlined text-base">logout</span>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('guardian.logout') }}" method="POST" class="d-none" style="display: none;">
            @csrf
        </form>
    </div>
</aside>
