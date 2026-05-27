<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">Forgot Password?</h2>
            <p class="mt-2 text-sm text-gray-600">
                No worries! Just enter your email and we'll send you a reset link.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="email" class="block mt-2 w-full h-12 text-base" type="email" name="email" :value="old('email')" required autofocus placeholder="your.email@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-primary-button class="w-full justify-center h-12 text-base font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
            
            <!-- Back to Login -->
            <div class="text-center pt-4 border-t border-gray-200">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 hover:text-indigo-300 transition">
                    ← Back to Login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>

