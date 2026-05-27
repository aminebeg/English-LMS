<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">Create Your Account</h2>
            <p class="mt-2 text-sm text-gray-600">Join our learning community today</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="name" class="block mt-2 w-full h-12 text-base" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="email" class="block mt-2 w-full h-12 text-base" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="your.email@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="password" class="block mt-2 w-full h-12 text-base" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="password_confirmation" class="block mt-2 w-full h-12 text-base" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-primary-button class="w-full justify-center h-12 text-base font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                    {{ __('Create Account') }}
                </x-primary-button>
            </div>

            <!-- Login Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 hover:text-indigo-300 transition">
                        Sign in
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>

