<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">Confirm Password</h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('This is a secure area. Please confirm your password before continuing.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="password" class="block mt-2 w-full h-12 text-base"
                                type="password"
                                name="password"
                                required autocomplete="current-password" 
                                placeholder="Enter your password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-primary-button class="w-full justify-center h-12 text-base font-semibold">
                    {{ __('Confirm Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>

