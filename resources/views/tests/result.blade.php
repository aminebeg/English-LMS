<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-900 dark:text-white leading-tight">
                {{ __('Test Results: ') }} {{ $test->title }}
            </h2>
            <a href="{{ route('enrollments.show', $test->course) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150">
                Back to Course
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Score Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-center">
                    <div class="mb-6">
                        @if($testResult->passed)
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-green-700 dark:text-green-400 mb-2">Passed!</h3>
                            <p class="text-gray-600 dark:text-gray-400">Great job! You've mastered this topic.</p>
                        @else
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-red-700 dark:text-red-400 mb-2">Not Passed</h3>
                            <p class="text-gray-600 dark:text-gray-400">Don't worry, review the material and try again.</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-3 gap-4 border-t border-gray-100 dark:border-gray-700 pt-6 mt-6">
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Your Score</div>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $testResult->score }}%</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Passing Score</div>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $test->passing_score }}%</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Completed</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white mt-2">
                                {{ $testResult->completed_at ? $testResult->completed_at->diffForHumans() : 'Just now' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Review -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">Detailed Review</h3>
                    
                    <div class="space-y-8">
                        @foreach($questions as $index => $question)
                            @php
                                $userAnswer = $testResult->answers[$question->id] ?? null;
                                $isCorrect = false;
                                
                                if ($question->type === 'short_answer') {
                                    $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer));
                                } else {
                                    $isCorrect = $userAnswer === $question->correct_answer;
                                }
                            @endphp

                            <div class="border-b border-gray-100 dark:border-gray-700 pb-6 last:border-0 last:pb-0">
                                <div class="flex items-start gap-3 mb-3">
                                    <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full {{ $isCorrect ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }} font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-grow">
                                        <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $question->content }}</h4>
                                    </div>
                                    <span class="flex-shrink-0">
                                        @if($isCorrect)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                Correct
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                Incorrect
                                            </span>
                                        @endif
                                    </span>
                                </div>

                                <div class="ml-11 space-y-3">
                                    <div class="p-3 rounded-md {{ $isCorrect ? 'bg-green-50 dark:bg-green-900/10 border border-green-100 dark:border-green-800' : 'bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-800' }}">
                                        <span class="text-xs font-bold uppercase tracking-wider block mb-1 {{ $isCorrect ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">Your Answer</span>
                                        <span class="text-gray-900 dark:text-white font-medium">{{ $userAnswer ?? 'No answer provided' }}</span>
                                    </div>

                                    @if(!$isCorrect)
                                        <div class="p-3 rounded-md bg-gray-50 dark:bg-gray-700/30 border border-gray-100 dark:border-gray-600">
                                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 block mb-1">Correct Answer</span>
                                            <span class="text-gray-900 dark:text-white font-medium">{{ $question->correct_answer }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-center gap-4 pt-4">
                <a href="{{ route('enrollments.show', $test->course) }}" class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition ease-in-out duration-150">
                    Back to Course
                </a>
                
                @if(!$testResult->passed)
                    <a href="{{ route('tests.start', $test) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-sm">
                        Retake Test
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
