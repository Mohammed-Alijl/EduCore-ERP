@extends('guardian.layouts.guest')

@section('title', 'Guardian Login - EduCore')

@section('content')
<div class="min-h-screen w-full flex bg-surface">

    <!-- Left Section: Abstract Hero (Hidden on Mobile) -->
    <div class="hidden lg:flex w-1/2 relative bg-primary items-center justify-center overflow-hidden">
        <!-- Abstract Background Vectors -->
        <div class="absolute inset-0 z-0 opacity-20 dark:opacity-10 mix-blend-overlay">
            <svg class="absolute top-0 left-0 w-full h-full transform scale-150" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0,0 Q50,100 100,0 L100,100 L0,100 Z" fill="currentColor" class="text-white"></path>
                <circle cx="20" cy="80" r="15" fill="currentColor" class="text-white opacity-50"></circle>
                <circle cx="80" cy="20" r="25" fill="currentColor" class="text-white opacity-30"></circle>
            </svg>
        </div>

        <div class="relative z-10 p-12 text-on-primary max-w-xl">
            <div class="mb-8 inline-flex items-center justify-center p-3 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-xl">
                <span class="material-symbols-outlined text-4xl text-white">family_home</span>
            </div>
            <h1 class="font-headline text-5xl font-extrabold mb-6 leading-tight tracking-tight text-white drop-shadow-md">
                Your Child's Education,<br>
                <span class="text-tertiary-fixed">Connected.</span>
            </h1>
            <p class="text-lg text-primary-fixed-dim leading-relaxed mb-12 max-w-md font-medium">
                Welcome to the Guardian Portal. Track academic progress, manage finances, and stay closely connected with the school community.
            </p>

            <div class="flex items-center gap-4 text-sm font-semibold text-primary-fixed-dim bg-black/10 w-max px-5 py-3 rounded-full backdrop-blur-sm border border-white/5">
                <span class="flex h-2.5 w-2.5 rounded-full bg-green-400 animate-pulse"></span>
                Secure Encrypted Portal
            </div>
        </div>
    </div>

    <!-- Right Section: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 md:p-24 relative overflow-hidden bg-surface">
        
        <!-- Subtle Ambient Glows -->
        <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-tertiary/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="w-full max-w-md relative z-10 glass-switcher p-8 sm:p-10 rounded-[2rem] shadow-2xl shadow-slate-200/50 dark:shadow-black/50 border border-outline-variant/30">
            
            <div class="mb-10 text-center lg:text-left">
                <div class="lg:hidden mb-6 inline-flex items-center justify-center p-3 bg-primary rounded-2xl shadow-lg shadow-primary/30">
                    <span class="material-symbols-outlined text-3xl text-on-primary">family_home</span>
                </div>
                <h2 class="text-3xl font-headline font-bold text-on-surface tracking-tight mb-2">Welcome Back</h2>
                <p class="text-on-surface-variant font-medium">Please enter your credentials to login.</p>
            </div>

            <!-- Session Status Hook (If flashed) -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('guardian.login.store') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-on-surface">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-[20px] text-outline group-focus-within:text-primary transition-colors">mail</span>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="block w-full pl-11 pr-4 py-3.5 bg-surface-container-lowest text-on-surface border border-outline-variant rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all placeholder:text-outline/60 outline-none shadow-sm"
                            placeholder="guardian@example.com">
                    </div>
                    @error('email')
                        <p class="text-sm font-medium text-error mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-semibold text-on-surface">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" tabindex="-1" class="text-xs font-bold text-primary hover:text-primary-container transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="relative group" x-data="{ showPassword: false }">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-[20px] text-outline group-focus-within:text-primary transition-colors">lock</span>
                        </div>
                        <input id="password" x-bind:type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password"
                            class="block w-full pl-11 pr-12 py-3.5 bg-surface-container-lowest text-on-surface border border-outline-variant rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all placeholder:text-outline/60 outline-none shadow-sm"
                            placeholder="••••••••">
                        <button type="button" @click="showPassword = !showPassword" tabindex="-1" class="absolute inset-y-0 right-0 pr-4 flex items-center text-outline hover:text-on-surface transition-colors focus:outline-none">
                            <span class="material-symbols-outlined text-[20px]" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-sm font-medium text-error mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center gap-3 pt-1">
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input id="remember_me" name="remember" type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary bg-surface-container-lowest transition-all cursor-pointer">
                        </div>
                        <div class="ml-2.5 text-sm">
                            <label for="remember_me" class="font-medium text-on-surface-variant cursor-pointer select-none">Remember this device</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-primary text-on-primary rounded-xl font-bold tracking-wide shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-0.5 active:translate-y-0 active:shadow-primary/30 transition-all">
                        Sign In to Portal
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
