<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $course->title }}
            </h2>
            <a href="{{ route('enrollments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                My Courses
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Course Overview -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Progress Section -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Your Progress</h3>
                            <span class="text-2xl font-bold text-indigo-600">{{ $progress }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                            <div class="bg-indigo-600 h-4 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                        </div>
                        
                        @if($progress == 100)
                            <div class="mt-4 p-4 bg-green-50 dark:bg-green-900 rounded-lg flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-green-800 dark:text-green-200">🎉 Course Completed!</h4>
                                    <p class="text-sm text-green-600 dark:text-green-300">You have successfully completed this course.</p>
                                </div>
                                <a href="{{ route('certificates.download', $course) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Download Certificate
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Course Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">About This Course</h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ $course->description }}</p>
                            <div class="flex gap-2 mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ ucfirst($course->type) }}
                                </span>
                                @if($course->level)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ $course->level }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Course Stats</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Instructor</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $course->tutor->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total Lessons</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $course->lessons->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total Tests</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $course->tests->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Enrolled</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $enrollment->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lessons Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">📚 Lessons</h3>
                    
                    @if($course->lessons->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No lessons available yet.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($course->lessons->sortBy('order') as $lesson)
                                @php
                                    $progress = $enrollment->progress ?? [];
                                    $completedLessons = $progress['completed_lessons'] ?? [];
                                    $isCompleted = in_array($lesson->id, $completedLessons);
                                @endphp

                                <div class="flex items-center justify-between p-4 border dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0">
                                            @if($isCompleted)
                                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $lesson->order }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $lesson->title }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($lesson->content, 100) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('lessons.show', $lesson) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">
                                        {{ $isCompleted ? 'Review' : 'Start' }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tests Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">📝 Tests</h3>
                    
                    @if($course->tests->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No tests available yet.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($course->tests->sortBy('order') as $test)
                                @php
                                    $progress = $enrollment->progress ?? [];
                                    $completedTests = $progress['completed_tests'] ?? [];
                                    $isCompleted = in_array($test->id, $completedTests);
                                @endphp

                                <div class="flex items-center justify-between p-4 border dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <div class="flex items-center gap-4 flex-1">
                                        <div class="flex-shrink-0">
                                            @if($isCompleted)
                                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-white">!</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $test->title }}</h4>
                                            <div class="flex gap-4 text-sm text-gray-600 dark:text-gray-400">
                                                <span>{{ $test->questions->count() }} Questions</span>
                                                <span>Passing Score: {{ $test->passing_score }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 text-sm">
                                        {{ $isCompleted ? 'Retake' : 'Start Test' }}
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
