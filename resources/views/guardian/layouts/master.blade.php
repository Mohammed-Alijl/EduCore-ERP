<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    @include('guardian.layouts.head')
</head>
<body class="bg-surface text-on-surface flex min-h-screen"
      x-data="{
          sidebarOpen: false,
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
      x-init="initTheme()"
      @keydown.escape="sidebarOpen = false">
    <!-- SideNavBar -->
    @include('guardian.layouts.main-sidebar')

    <main class="ms-0 md:ms-64 flex-1 flex flex-col min-w-0 transition-margin duration-300">
        <!-- TopNavBar -->
        @include('guardian.layouts.main-header')

        <!-- Main Content Canvas -->
        <div class="p-4 md:p-8 max-w-7xl mx-auto w-full space-y-6 md:space-y-8">
            @yield('content')
        </div>

        <!-- Footer -->
        @include('guardian.layouts.footer')
    </main>

    @stack('scripts')
</body>
</html>
