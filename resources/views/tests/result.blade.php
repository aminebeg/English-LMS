<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Score Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8 text-center">
                    <div class="mb-6">
                        @if($testResult->passed)
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-emerald-700 mb-2">Passed! 🎉</h2>
                            <p class="text-gray-600">Great job! You've mastered this topic.</p>
                        @else
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 text-red-600 mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-red-700 mb-2">Not Passed</h2>
                            <p class="text-gray-600">Don't worry — review the material and try again.</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-6 mt-2">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Your Score</p>
                            <p class="text-4xl font-bold {{ $testResult->passed ? 'text-emerald-600' : 'text-red-600' }} mt-1">{{ $testResult->score }}%</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Passing Score</p>
                            <p class="text-4xl font-bold text-gray-800 mt-1">{{ $test->passing_score }}%</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Completed</p>
                            <p class="text-base font-semibold text-gray-700 mt-2">
                                {{ $testResult->completed_at ? $testResult->completed_at->diffForHumans() : 'Just now' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Review -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">Detailed Review</h3>
                    <p class="text-sm text-gray-500 mt-0.5">See how you did on each question</p>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach($questions as $index => $question)
                        @php
                            $userAnswer = $testResult->answers[$question->id] ?? null;
                            $isCorrect = $question->type === 'short_answer'
                                ? strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer))
                                : $userAnswer === $question->correct_answer;
                        @endphp

                        <div class="p-6">
                            <div class="flex items-start gap-3 mb-4">
                                <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-lg
                                    {{ $isCorrect ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}
                                    font-bold text-sm">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-grow min-w-0">
                                    <p class="text-base font-semibold text-gray-900">{{ $question->content }}</p>
                                </div>
                                @if($isCorrect)
                                    <span class="flex-shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Correct
                                    </span>
                                @else
                                    <span class="flex-shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        Incorrect
                                    </span>
                                @endif
                            </div>

                            <div class="ml-11 space-y-2">
                                <div class="p-3 rounded-lg {{ $isCorrect ? 'bg-emerald-50 border border-emerald-200' : 'bg-red-50 border border-red-200' }}">
                                    <p class="text-xs font-bold uppercase tracking-wider mb-1 {{ $isCorrect ? 'text-emerald-600' : 'text-red-600' }}">Your Answer</p>
                                    <p class="text-sm text-gray-900 font-medium">{{ $userAnswer ?? 'No answer provided' }}</p>
                                </div>

                                @if(!$isCorrect)
                                    <div class="p-3 rounded-lg bg-gray-50 border border-gray-200">
                                        <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Correct Answer</p>
                                        <p class="text-sm text-gray-900 font-medium">{{ $question->correct_answer }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row justify-center gap-3 pb-4">
                <a href="{{ route('enrollments.show', $test->course) }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Course
                </a>

                @if(!$testResult->passed)
                    <a href="{{ route('tests.start', $test) }}"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Retake Test
                    </a>
                @endif

                <a href="{{ route('tests.my-results') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                    All My Results
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
