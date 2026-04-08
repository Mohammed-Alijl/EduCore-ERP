<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    @include('guardian.layouts.head')
</head>
<body class="bg-surface text-on-surface flex min-h-screen">
    <!-- SideNavBar -->
    @include('guardian.layouts.main-sidebar')

    <main class="ml-64 flex-1 flex flex-col">
        <!-- TopNavBar -->
        @include('guardian.layouts.main-header')

        <!-- Main Content Canvas -->
        <div class="p-8 max-w-7xl mx-auto w-full space-y-8">
            @yield('content')
        </div>

        <!-- Footer -->
        @include('guardian.layouts.footer')
    </main>

    @stack('scripts')
</body>
</html>
