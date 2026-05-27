<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">My Courses</h1>
                    <p class="text-gray-600">Track your progress and continue learning</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('courses.browse') }}"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse More Courses
                    </a>
                </div>
            </div>

            @if ($enrollments->isEmpty())
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <div
                        class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No courses yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">You haven't enrolled in any courses. Explore our
                        catalog to find your next learning adventure.</p>
                    <a href="{{ route('courses.browse') }}"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                        Start Learning
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($enrollments as $enrollment)
                        @php
                            $course = $enrollment->course;
                            $progress = $course->getProgressFor(auth()->user());
                        @endphp

                        <div
                            class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full">
                            <!-- Course Image Placeholder -->
                            <div
                                class="h-48 bg-indigo-100 flex items-center justify-center relative group">
                                <svg class="w-16 h-16 text-indigo-300" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                                <div class="absolute top-4 right-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-gray-800 backdrop-blur-sm shadow-sm">
                                        {{ ucfirst($course->type) }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 flex-1 flex flex-col">
                                <div class="mb-4 flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                                        {{ $course->title }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        by <span class="font-medium text-gray-900">{{ $course->tutor->name }}</span>
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Enrolled {{ $enrollment->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <!-- Progress -->
                                <div class="mb-6">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="font-medium text-gray-700">Progress</span>
                                        <span
                                            class="font-bold text-indigo-600">{{ $progress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500"
                                            style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-6 pt-4 border-t border-gray-100">
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-gray-900">{{ $course->lessons->count() }}
                                        </div>
                                        <div class="text-xs text-gray-500 uppercase tracking-wide">Lessons</div>
                                    </div>
                                    <div class="text-center border-l border-gray-100">
                                        <div class="text-lg font-bold text-gray-900">{{ $course->tests->count() }}</div>
                                        <div class="text-xs text-gray-500 uppercase tracking-wide">Tests</div>
                                    </div>
                                </div>

                                <a href="{{ route('enrollments.show', $course) }}"
                                    class="block w-full text-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm">
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
