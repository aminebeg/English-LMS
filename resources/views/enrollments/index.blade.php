<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Courses') }}
            </h2>
            <a href="{{ route('courses.browse') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                Browse More Courses
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if($enrollments->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="mb-4">You haven't enrolled in any courses yet.</p>
                        <a href="{{ route('courses.browse') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Browse Courses
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($enrollments as $enrollment)
                        @php
                            $course = $enrollment->course;
                            $progress = $course->getProgressFor(auth()->user());
                        @endphp

                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <!-- Course Header -->
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">
                                            {{ $course->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            by {{ $course->tutor->name }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ ucfirst($course->type) }}
                                    </span>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-400">Progress</span>
                                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $progress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>

                                <!-- Course Stats -->
                                <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="font-bold text-gray-900 dark:text-gray-100">{{ $course->lessons->count() }}</div>
                                        <div class="text-gray-600 dark:text-gray-400">Lessons</div>
                                    </div>
                                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="font-bold text-gray-900 dark:text-gray-100">{{ $course->tests->count() }}</div>
                                        <div class="text-gray-600 dark:text-gray-400">Tests</div>
                                    </div>
                                </div>

                                <!-- Enrollment Date -->
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                                    Enrolled on {{ $enrollment->created_at->format('M d, Y') }}
                                </p>

                                <!-- Action Button -->
                                <a href="{{ route('enrollments.show', $course) }}" class="block w-full text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    Continue Learning
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
