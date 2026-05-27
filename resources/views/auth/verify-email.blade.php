<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900">Verify Your Email</h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
            </p>
        </div>

        <!-- Success Message -->
        @if (session('status') == 'verification-link-sent')
            <div class="p-4 bg-green-50 border-2 border-green-200 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-green-800">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full justify-center h-12 text-base font-semibold">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <div class="text-center pt-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition">
                        {{ __('← Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

