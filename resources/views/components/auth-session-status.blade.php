@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-4 bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-lg']) }}>
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-green-500 dark:text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-green-800 dark:text-green-200">
                {{ $status }}
            </p>
        </div>
    </div>
@endif
