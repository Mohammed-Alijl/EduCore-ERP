<aside
    class="h-screen w-64 fixed left-0 top-0 z-40 bg-[#001a42] dark:bg-slate-950 flex flex-col py-6 gap-2 font-inter body-md tracking-wide">
    <div class="px-6 mb-8 relative" x-data="{ open: false }" @click.away="open = false">
        <div @click="open = !open" 
             class="flex items-center gap-3 glass-switcher p-2 rounded-xl shadow-sm cursor-pointer border border-transparent transition-all"
             :class="{'ring-2 ring-primary/50 border-primary/20': open, 'hover:bg-white/90': !open}">
            <div class="h-10 w-10 rounded-full overflow-hidden bg-surface-container-highest ring-2 ring-primary">
                <img class="h-full w-full object-cover" data-alt="Student portrait"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzb-EThc0w5Jad5VuvQfwax6Ag6JOAsRIZcwf0ENssXI730f7hZplJ2x-x0YFcm10eTP-DHgKtKl7pku4jZIR4Z8NGUZ5gBkgw2T52qDG-PG-SYO33LZK-I8YKHqP2gUHJlMwgM_Kp4BrPvSX3IAqCsVDrpTjE7yU6V7pGmcOqIm-o0zfKF_vtwkCvymez48Is7NvJXDid7PyDIKotNnV7LfCscy_ZdffKQ_wOXNQ3RbrWQvnjDO_2KuAhPy_mN7Pwdx50J_qTphk" />
            </div>
            <div>
                <p class="text-xs font-bold text-on-primary-fixed uppercase tracking-tighter">Julian Anderson</p>
                <p class="text-[10px] text-slate-500 font-medium">Grade 10-B</p>
            </div>
            <span class="material-symbols-outlined text-slate-400 ml-auto text-sm transition-transform duration-200" :class="{'rotate-180': open}">unfold_more</span>
        </div>

        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
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
                <button class="w-full flex items-center gap-3 p-2 rounded-lg bg-primary/5 text-left transition-colors relative">
                    <div class="h-8 w-8 rounded-full overflow-hidden shrink-0 ring-1 ring-primary">
                        <img class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzb-EThc0w5Jad5VuvQfwax6Ag6JOAsRIZcwf0ENssXI730f7hZplJ2x-x0YFcm10eTP-DHgKtKl7pku4jZIR4Z8NGUZ5gBkgw2T52qDG-PG-SYO33LZK-I8YKHqP2gUHJlMwgM_Kp4BrPvSX3IAqCsVDrpTjE7yU6V7pGmcOqIm-o0zfKF_vtwkCvymez48Is7NvJXDid7PyDIKotNnV7LfCscy_ZdffKQ_wOXNQ3RbrWQvnjDO_2KuAhPy_mN7Pwdx50J_qTphk" />
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-primary">Julian Anderson</p>
                        <p class="text-[9px] text-slate-500 font-medium">Grade 10-B</p>
                    </div>
                    <span class="material-symbols-outlined text-sm text-primary">check_circle</span>
                </button>
                
                <!-- Inactive Student 1 -->
                <button class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700/50 text-left transition-colors">
                    <div class="h-8 w-8 rounded-full overflow-hidden shrink-0 ring-1 ring-slate-200">
                        <img class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA7yZc3SReAts56V6Z_xJt6C6eX5l40v55rL2i01yS_kZKVn2Q57M9Jz2g_cE28vR_t12S_H01_pS__S_o982_bJ5D940J1Y_Q2gE0sV_5H5c6QO0L7B9T0A5P_7Y_o4L476O0P8sL7E20B_1_Y28S9Z820B_p_O4P_B9P3S3r9A_G1D_k8X2o_B5Z5R_" />
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Maya Anderson</p>
                        <p class="text-[9px] text-slate-500 font-medium">Grade 7-A</p>
                    </div>
                </button>
                
                <!-- Inactive Student 2 -->
                <button class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700/50 text-left transition-colors">
                    <div class="h-8 w-8 rounded-full overflow-hidden shrink-0 ring-1 ring-slate-200">
                        <div class="h-full w-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <span class="material-symbols-outlined text-sm">person</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Leo Anderson</p>
                        <p class="text-[9px] text-slate-500 font-medium">Grade 3-C</p>
                    </div>
                </button>
            </div>
            
            <div class="p-2 border-t border-slate-100 dark:border-slate-700">
                <button class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs text-primary bg-primary/5 hover:bg-primary/10 rounded-lg transition-colors font-bold">
                    <span class="material-symbols-outlined text-[16px]">add</span>
                    Link Another Child
                </button>
            </div>
        </div>
    </div>

    <nav class="flex-1 space-y-1">
        <a class="flex items-center gap-3 bg-[#2170e4] text-white rounded-full px-4 py-3 mx-2 transition-transform duration-200 ease-out"
            href="{{ route('guardian.dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a class="flex items-center gap-3 text-slate-300 px-4 py-3 mx-2 hover:text-white hover:bg-white/10 rounded-full transition-all"
            href="#">
            <span class="material-symbols-outlined">school</span>
            <span>Academics</span>
        </a>
        <a class="flex items-center gap-3 text-slate-300 px-4 py-3 mx-2 hover:text-white hover:bg-white/10 rounded-full transition-all"
            href="#">
            <span class="material-symbols-outlined">payments</span>
            <span>Finance</span>
        </a>
        <a class="flex items-center gap-3 text-slate-300 px-4 py-3 mx-2 hover:text-white hover:bg-white/10 rounded-full transition-all"
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
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">
            @csrf
        </form>
    </div>
</aside>
