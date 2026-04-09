<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    @include('guardian.layouts.head')
</head>
<body class="bg-surface text-on-surface antialiased min-h-screen flex items-center justify-center selection:bg-primary selection:text-white"
      x-data="{
          theme: 'light',
          initTheme() {
              this.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
          },
          applyTheme(value) {
              this.theme = value;
              document.documentElement.classList.toggle('dark', value === 'dark');
              document.documentElement.classList.toggle('light', value !== 'dark');
              localStorage.setItem('guardian-theme', value);
          },
          toggleTheme() {
              this.applyTheme(this.theme === 'dark' ? 'light' : 'dark');
          }
      }"
      x-init="initTheme()">

    <!-- Theme Toggle positioned top right -->
    <div class="absolute top-6 right-6 z-50">
        <button @click="toggleTheme()"
            class="h-10 w-10 flex items-center justify-center rounded-xl bg-white/50 dark:bg-slate-800/50 backdrop-blur-md border border-slate-200/50 dark:border-slate-700/50 text-slate-600 dark:text-slate-300 hover:scale-105 hover:bg-white dark:hover:bg-slate-800 transition-all shadow-sm">
            <span class="material-symbols-outlined text-[20px]" x-show="theme === 'light'">dark_mode</span>
            <span class="material-symbols-outlined text-[20px]" x-show="theme === 'dark'" style="display: none;" x-cloak>light_mode</span>
        </button>
    </div>

    <!-- Main Content Canvas -->
    <main class="w-full">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
