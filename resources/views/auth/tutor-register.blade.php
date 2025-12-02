<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Become a Tutor</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Join our community of expert educators</p>
        </div>

        <form method="POST" action="{{ route('tutor.register') }}" class="space-y-5">
            @csrf

            <!-- Info Box -->
            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 border-2 border-indigo-100 dark:border-indigo-800 rounded-lg flex gap-3">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-indigo-800 dark:text-indigo-200">
                    Your application will be reviewed by our editorial team. Once approved, you can start creating courses.
                </p>
            </div>

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" class="text-sm font-semibold text-gray-700 dark:text-gray-300" />
                <x-text-input id="name" class="block mt-2 w-full h-12 text-base" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700 dark:text-gray-300" />
                <x-text-input id="email" class="block mt-2 w-full h-12 text-base" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="your.email@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Bio (Optional) -->
            <div>
                <x-input-label for="bio" :value="__('Bio (Optional)')" class="text-sm font-semibold text-gray-700 dark:text-gray-300" />
                <textarea id="bio" name="bio" rows="4" class="block mt-2 w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 rounded-lg shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 dark:focus:ring-indigo-400/20 transition-all duration-200" placeholder="Tell us about your teaching experience and qualifications...">{{ old('bio') }}</textarea>
                <x-input-error :messages="$errors->get('bio')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700 dark:text-gray-300" />
                <x-text-input id="password" class="block mt-2 w-full h-12 text-base"
                                type="password"
                                name="password"
                                required autocomplete="new-password" 
                                placeholder="Create a strong password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-gray-700 dark:text-gray-300" />
                <x-text-input id="password_confirmation" class="block mt-2 w-full h-12 text-base"
                                type="password"
                                name="password_confirmation" 
                                required autocomplete="new-password" 
                                placeholder="Confirm your password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-primary-button class="w-full justify-center h-12 text-base font-semibold">
                    {{ __('Apply Now') }}
                </x-primary-button>
            </div>

            <!-- Login Link -->
            <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Already registered?
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition">
                        Sign in
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
