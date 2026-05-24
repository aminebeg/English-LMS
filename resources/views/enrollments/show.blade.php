<x-app-layout>
    <!-- Hero Section with Course Header -->
    <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('enrollments.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg hover:bg-white/20 transition-all duration-200 text-white font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    My Courses
                </a>
                
                @if($course->category)
                    <span class="px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg text-sm font-medium">
                        {{ $course->category }}
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Course Info -->
                <div class="lg:col-span-2">
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">{{ $course->title }}</h1>
                    <p class="text-lg text-white/90 mb-6 leading-relaxed">{{ $course->description }}</p>
                    
                    <div class="flex flex-wrap gap-3 mb-6">
                        @if($course->level)
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span class="font-medium">{{ $course->level }}</span>
                            </div>
                        @endif
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="font-medium">{{ $course->lessons->count() }} Lessons</span>
                        </div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="font-medium">{{ $course->tutor->name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold">Your Progress</h3>
                        <span class="text-3xl font-extrabold">{{ $progress }}%</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-3 mb-4">
                        <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-3 rounded-full transition-all duration-500 shadow-lg" style="width: {{ $progress }}%"></div>
                    </div>
                    
                    @if($progress == 100)
                        <div class="mt-4 p-4 bg-green-500/20 backdrop-blur-sm rounded-xl border border-green-400/30">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h4 class="font-bold text-green-100">Course Completed!</h4>
                            </div>
                            <a href="{{ route('certificates.download', $course) }}" class="mt-3 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all duration-200 font-semibold shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download Certificate
                            </a>
                        </div>
                    @else
                        <div class="text-sm text-white/80 space-y-2">
                            <div class="flex justify-between">
                                <span>Completed Lessons</span>
                                <span class="font-semibold">{{ count($enrollment->progress['completed_lessons'] ?? []) }} / {{ $course->lessons->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Enrollment Date</span>
                                <span class="font-semibold">{{ $enrollment->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Course Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Course Curriculum -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 from-to-px-8 py-6 border-b border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-extrabold text->Course Curriculum</h2>
                                    <p class="text-sm text-gray-600">{{ $course->lessons->count() }} lessons to complete</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            @if($course->sections->isNotEmpty())
                                <div class="space-y-6">
                                    @foreach($course->sections as $section)
                                        <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300">
                                            <!-- Section Header -->
                                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 from-to-px-6 py-4 border-b border-gray-200">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 bg-indigo-100 bg-rounded-lg flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h3 class="text-lg font-bold text->{{ $section->title }}</h3>
                                                            @if($section->description)
                                                                <p class="text-sm text-gray-600 mt-0.5">{{ $section->description }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <span class="px-3 py-1.5 bg-indigo-50 bg-text-indigo-700 rounded-lg text-xs font-bold">
                                                        {{ $section->lessons->count() }} Lessons
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Lessons in Section -->
                                            <div class="divide-y divide-gray-100 divide->
                                                @foreach($section->lessons as $lesson)
                                                    @php
                                                        $progress = $enrollment->progress ?? [];
                                                        $completedLessons = $progress['completed_lessons'] ?? [];
                                                        $isCompleted = in_array($lesson->id, $completedLessons);
                                                    @endphp
                                                    <div class="group hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 hover:from-hover:to-transition-all duration-200">
                                                        <div class="flex items-center justify-between p-5">
                                                            <div class="flex items-center gap-4 flex-1">
                                                                <!-- Status Icon -->
                                                                <div class="flex-shrink-0">
                                                                    @if($isCompleted)
                                                                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform">
                                                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                                            </svg>
                                                                        </div>
                                                                    @else
                                                                        <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 from-to-gray-600 rounded-xl flex items-center justify-center group-hover:from-indigo-100 group-hover:to-purple-100 group-hover:from-group-hover:to-transition-all shadow-md">
                                                                            <span class="text-lg font-bold text-gray-600 group-hover:text-indigo-600 group-hover:>{{ $loop->iteration }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <!-- Lesson Info -->
                                                                <div class="flex-1 min-w-0">
                                                                    <h4 class="font-bold text-group-hover:text-indigo-600 group-hover:transition-colors mb-1">
                                                                        {{ $lesson->title }}
                                                                    </h4>
                                                                    @if($lesson->duration_minutes)
                                                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                            </svg>
                                                                            <span>{{ $lesson->formatted_duration }}</span>
                                                                            @if($isCompleted)
                                                                                <span class="px-2 py-0.5 bg-green-100 bg-text-green-700 rounded-full text-xs font-semibold">Completed</span>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Action Button -->
                                                            <a href="{{ route('learn.lessons.show', $lesson) }}" class="flex-shrink-0 ml-4 px-6 py-3 {{ $isCompleted ? 'bg-white bg-text-text-gray-200 border border-gray-300 hover:border-indigo-400 hover:border-indigo-500' : 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:from-indigo-700 hover:to-purple-700' }} rounded-xl font-semibold transition-all duration-200 shadow-md hover:shadow-xl transform hover:scale-105">
                                                                @if($isCompleted)
                                                                    <span class="flex items-center gap-2">
                                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                                        </svg>
                                                                        Review
                                                                    </span>
                                                                @else
                                                                    <span class="flex items-center gap-2">
                                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                        </svg>
                                                                        Start Lesson
                                                                    </span>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Orphaned Lessons -->
                                    @php
                                        $orphanedLessons = $course->lessons->whereNull('course_section_id')->sortBy('order');
                                    @endphp
                                    @if($orphanedLessons->isNotEmpty())
                                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                                            <div class="bg-gray-50 bg-px-6 py-4 border-b border-gray-200">
                                                <h3 class="text-lg font-bold text->Additional Lessons</h3>
                                            </div>
                                            <div class="divide-y divide-gray-100 divide->
                                                @foreach($orphanedLessons as $lesson)
                                                    @php
                                                        $progress = $enrollment->progress ?? [];
                                                        $completedLessons = $progress['completed_lessons'] ?? [];
                                                        $isCompleted = in_array($lesson->id, $completedLessons);
                                                    @endphp
                                                    <!-- Same lesson card structure as above -->
                                                    <div class="group hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 hover:from-hover:to-transition-all duration-200">
                                                        <div class="flex items-center justify-between p-5">
                                                            <div class="flex items-center gap-4 flex-1">
                                                                <div class="flex-shrink-0">
                                                                    @if($isCompleted)
                                                                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                                                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                                            </svg>
                                                                        </div>
                                                                    @else
                                                                        <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 from-to-gray-600 rounded-xl flex items-center justify-center shadow-md">
                                                                            <span class="text-lg font-bold text-gray-600">{{ $loop->iteration }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="flex-1">
                                                                    <h4 class="font-bold text->{{ $lesson->title }}</h4>
                                                                    @if($lesson->duration_minutes)
                                                                        <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                            </svg>
                                                                            <span>{{ $lesson->formatted_duration }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <a href="{{ route('learn.lessons.show', $lesson) }}" class="ml-4 px-6 py-3 {{ $isCompleted ? 'bg-white bg-text-text-gray-200' : 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white' }} rounded-xl font-semibold transition-all">
                                                                {{ $isCompleted ? 'Review' : 'Start Lesson' }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Flat List (No Sections) -->
                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <div class="divide-y divide-gray-100 divide->
                                        @foreach($course->lessons->sortBy('order') as $lesson)
                                            @php
                                                $progress = $enrollment->progress ?? [];
                                                $completedLessons = $progress['completed_lessons'] ?? [];
                                                $isCompleted = in_array($lesson->id, $completedLessons);
                                            @endphp
                                            <div class="group hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 hover:from-hover:to-transition-all duration-200">
                                                <div class="flex items-center justify-between p-5">
                                                    <div class="flex items-center gap-4 flex-1">
                                                        <div class="flex-shrink-0">
                                                            @if($isCompleted)
                                                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform">
                                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                                    </svg>
                                                                </div>
                                                            @else
                                                                <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 from-to-gray-600 rounded-xl flex items-center justify-center group-hover:from-indigo-100 group-hover:to-purple-100 group-hover:from-group-hover:to-transition-all shadow-md">
                                                                    <span class="text-lg font-bold text-gray-600 group-hover:text-indigo-600">{{ $loop->iteration }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <h4 class="font-bold text-group-hover:text-indigo-600 group-hover:transition-colors mb-1">
                                                                {{ $lesson->title }}
                                                            </h4>
                                                            @if($lesson->duration_minutes)
                                                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                    </svg>
                                                                    <span>{{ $lesson->formatted_duration }}</span>
                                                                    @if($isCompleted)
                                                                        <span class="px-2 py-0.5 bg-green-100 bg-text-green-700 rounded-full text-xs font-semibold">Completed</span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('learn.lessons.show', $lesson) }}" class="flex-shrink-0 ml-4 px-6 py-3 {{ $isCompleted ? 'bg-white bg-text-text-gray-200 border border-gray-300' : 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white' }} rounded-xl font-semibold transition-all duration-200 shadow-md hover:shadow-xl transform hover:scale-105">
                                                        @if($isCompleted)
                                                            <span class="flex items-center gap-2">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                                </svg>
                                                                Review
                                                            </span>
                                                        @else
                                                            <span class="flex items-center gap-2">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                Start Lesson
                                                            </span>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Tests & Info -->
                <div class="space-y-6">
                    <!-- Tests Card -->
                    @if($course->tests->isNotEmpty())
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden sticky top-24">
                            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 from-to-px-6 py-5 border-b border-gray-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text->Course Tests</h3>
                                        <p class="text-sm text-gray-600">{{ $course->tests->count() }} test{{ $course->tests->count()> 1 ? 's' : '' }} available</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 space-y-4">
                                @foreach($course->tests->sortBy('order') as $test)
                                    @php
                                        $progress = $enrollment->progress ?? [];
                                        $completedTests = $progress['completed_tests'] ?? [];
                                        $isCompleted = in_array($test->id, $completedTests);
                                    @endphp
                                    <div class="border border-gray-200 rounded-xl p-4 hover:shadow-lg transition-all duration-200 hover:border-yellow-400 hover:border-yellow-500">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="flex-shrink-0 w-10 h-10 {{ $isCompleted ? 'bg-green-500' : 'bg-yellow-500' }} rounded-lg flex items-center justify-center shadow-md">
                                                @if($isCompleted)
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-bold text-mb-1">{{ $test->title }}</h4>
                                                <div class="space-y-1 text-xs text-gray-600">
                                                    <div class="flex items-center gap-1.5">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <span>{{ $test->questions->count() }} Questions</span>
                                                    </div>
                                                    <div class="flex items-center gap-1.5">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <span>Pass: {{ $test->passing_score }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('tests.start', $test) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 {{ $isCompleted ? 'bg-gray-100 bg-text-text-gray-200 hover:bg-gray-200' : 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white hover:from-yellow-600 hover:to-orange-600' }} rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                                            {{ $isCompleted ? 'Retake Test' : 'Start Test' }}
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Course Info Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Quick Stats
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 border->
                                <span class="text-gray-600 font-medium">Total Lessons</span>
                                <span class="font-bold text->{{ $course->lessons->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 border->
                                <span class="text-gray-600 font-medium">Completed</span>
                                <span class="font-bold text-green-600">{{ count($enrollment->progress['completed_lessons'] ?? []) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 border->
                                <span class="text-gray-600 font-medium">Tests</span>
                                <span class="font-bold text->{{ $course->tests->count() }}</span>
                            </div>
                            @if($course->category)
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 font-medium">Category</span>
                                    <span class="px-2 py-1 bg-indigo-50 bg-text-indigo-700 rounded text-xs font-semibold">{{ $course->category }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

