<aside
    class="h-screen w-64 fixed left-0 top-0 z-40 bg-[#001a42] dark:bg-slate-950 flex flex-col py-6 gap-2 font-inter body-md tracking-wide">
    <div class="px-6 mb-8">
        <div class="flex items-center gap-3 glass-switcher p-2 rounded-xl shadow-sm cursor-pointer">
            <div class="h-10 w-10 rounded-full overflow-hidden bg-surface-container-highest ring-2 ring-primary">
                <img class="h-full w-full object-cover" data-alt="Student portrait"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzb-EThc0w5Jad5VuvQfwax6Ag6JOAsRIZcwf0ENssXI730f7hZplJ2x-x0YFcm10eTP-DHgKtKl7pku4jZIR4Z8NGUZ5gBkgw2T52qDG-PG-SYO33LZK-I8YKHqP2gUHJlMwgM_Kp4BrPvSX3IAqCsVDrpTjE7yU6V7pGmcOqIm-o0zfKF_vtwkCvymez48Is7NvJXDid7PyDIKotNnV7LfCscy_ZdffKQ_wOXNQ3RbrWQvnjDO_2KuAhPy_mN7Pwdx50J_qTphk" />
            </div>
            <div>
                <p class="text-xs font-bold text-on-primary-fixed uppercase tracking-tighter">Julian Anderson</p>
                <p class="text-[10px] text-slate-500 font-medium">Grade 10-B</p>
            </div>
            <span class="material-symbols-outlined text-slate-400 ml-auto text-sm">unfold_more</span>
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
