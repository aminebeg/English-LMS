<x-app-layout>
    {{-- Tutor Preview Banner --}}
    @if(auth()->user()->hasRole('tutor') && $course->tutor_id === auth()->id())
        <div class="sticky top-0 z-50 bg-amber-500 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm leading-tight">Student Preview Mode</p>
                        <p class="text-amber-100 text-xs">You are viewing this course as a student would see it.</p>
                    </div>
                </div>
                <a href="{{ route('courses.show', $course) }}"
                   class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-white text-amber-600 rounded-lg font-semibold text-sm hover:bg-amber-50 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Tutor View
                </a>
            </div>
        </div>
    @endif

    {{-- Hero Section with Course Header --}}
    <div class="bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('enrollments.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg hover:bg-white/20 transition-all duration-200 text-white font-medium text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <h1 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">{{ $course->title }}</h1>
                    <p class="text-base text-white/85 mb-6 leading-relaxed">{{ $course->description }}</p>
                    <div class="flex flex-wrap gap-3 mb-6">
                        @if($course->level)
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 backdrop-blur-sm rounded-lg text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span class="font-medium">{{ $course->level }}</span>
                            </div>
                        @endif
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 backdrop-blur-sm rounded-lg text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="font-medium">{{ $course->lessons->count() }} Lessons</span>
                        </div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/15 backdrop-blur-sm rounded-lg text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="font-medium">{{ $course->tutor->name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-white">Your Progress</h3>
                        <span class="text-3xl font-extrabold text-white">{{ $progress }}%</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-2.5 mb-4">
                        <div class="bg-gradient-to-r from-green-400 to-emerald-400 h-2.5 rounded-full transition-all duration-500 shadow-sm"
                            style="width: {{ $progress }}%"></div>
                    </div>

                    @if($progress == 100)
                        <div class="mt-4 p-4 bg-green-500/20 backdrop-blur-sm rounded-xl border border-green-400/30">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h4 class="font-bold text-green-100">Course Completed!</h4>
                            </div>
                            <a href="{{ route('certificates.download', $course) }}"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all duration-200 font-semibold shadow-lg text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <span>Enrolled</span>
                                <span class="font-semibold">{{ $enrollment->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="bg-gray-50 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Course Curriculum -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Header -->
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Course Curriculum</h2>
                                <p class="text-xs text-gray-500">{{ $course->lessons->count() }} lessons to complete</p>
                            </div>
                        </div>

                        <div class="p-6">
                            @if($course->sections->isNotEmpty())
                                <div class="space-y-5">
                                    @foreach($course->sections as $section)
                                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                                            <!-- Section Header -->
                                            <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-bold text-gray-900">{{ $section->title }}</h3>
                                                        @if($section->description)
                                                            <p class="text-xs text-gray-500 mt-0.5">{{ $section->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold">
                                                    {{ $section->lessons->count() }} Lessons
                                                </span>
                                            </div>

                                            <!-- Lessons in Section -->
                                            <div class="divide-y divide-gray-50">
                                                @foreach($section->lessons as $lesson)
                                                    @php
                                                        $progressData = $enrollment->progress ?? [];
                                                        $completedLessons = $progressData['completed_lessons'] ?? [];
                                                        $isCompleted = in_array($lesson->id, $completedLessons);
                                                    @endphp
                                                    <div class="flex items-center justify-between p-4 hover:bg-indigo-50/40 transition-colors group">
                                                        <div class="flex items-center gap-4 flex-1">
                                                            <!-- Status Icon -->
                                                            <div class="flex-shrink-0">
                                                                @if($isCompleted)
                                                                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-sm">
                                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                                        </svg>
                                                                    </div>
                                                                @else
                                                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-100 transition-colors shadow-sm">
                                                                        <span class="text-sm font-bold text-gray-500 group-hover:text-indigo-600 transition-colors">{{ $loop->iteration }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <!-- Lesson Info -->
                                                            <div class="flex-1 min-w-0">
                                                                <h4 class="font-semibold text-gray-900 group-hover:text-indigo-700 transition-colors text-sm">{{ $lesson->title }}</h4>
                                                                @if($lesson->duration_minutes)
                                                                    <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                        </svg>
                                                                        <span>{{ $lesson->formatted_duration }}</span>
                                                                        @if($isCompleted)
                                                                            <span class="px-1.5 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-semibold">Completed</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <!-- Action Button -->
                                                        <a href="{{ route('learn.lessons.show', $lesson) }}"
                                                            class="flex-shrink-0 ml-3 inline-flex items-center gap-1.5 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-200 shadow-sm
                                                            {{ $isCompleted
                                                                ? 'bg-gray-100 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 border border-gray-200'
                                                                : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                                                            @if($isCompleted)
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                                </svg>
                                                                Review
                                                            @else
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                Start
                                                            @endif
                                                        </a>
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
                                            <div class="bg-gray-50 px-5 py-3 border-b border-gray-200">
                                                <h3 class="font-bold text-gray-700 text-sm">Additional Lessons</h3>
                                            </div>
                                            <div class="divide-y divide-gray-50">
                                                @foreach($orphanedLessons as $lesson)
                                                    @php
                                                        $progressData2 = $enrollment->progress ?? [];
                                                        $completedLessons2 = $progressData2['completed_lessons'] ?? [];
                                                        $isCompleted2 = in_array($lesson->id, $completedLessons2);
                                                    @endphp
                                                    <div class="flex items-center justify-between p-4 hover:bg-indigo-50/40 transition-colors group">
                                                        <div class="flex items-center gap-4 flex-1">
                                                            <div class="flex-shrink-0">
                                                                @if($isCompleted2)
                                                                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-sm">
                                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                                        </svg>
                                                                    </div>
                                                                @else
                                                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-100 transition-colors shadow-sm">
                                                                        <span class="text-sm font-bold text-gray-500 group-hover:text-indigo-600 transition-colors">{{ $loop->iteration }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-1">
                                                                <h4 class="font-semibold text-gray-900 text-sm">{{ $lesson->title }}</h4>
                                                                @if($lesson->duration_minutes)
                                                                    <div class="flex items-center gap-1.5 text-xs text-gray-500 mt-0.5">
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                        </svg>
                                                                        <span>{{ $lesson->formatted_duration }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('learn.lessons.show', $lesson) }}"
                                                            class="ml-3 inline-flex items-center gap-1.5 px-4 py-2 rounded-lg font-semibold text-sm transition-all shadow-sm
                                                            {{ $isCompleted2 ? 'bg-gray-100 text-gray-600 border border-gray-200 hover:bg-indigo-50 hover:text-indigo-600' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                                                            {{ $isCompleted2 ? 'Review' : 'Start' }}
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Flat List (No Sections) -->
                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <div class="divide-y divide-gray-50">
                                        @foreach($course->lessons->sortBy('order') as $lesson)
                                            @php
                                                $progressFlat = $enrollment->progress ?? [];
                                                $completedFlat = $progressFlat['completed_lessons'] ?? [];
                                                $isFlatCompleted = in_array($lesson->id, $completedFlat);
                                            @endphp
                                            <div class="flex items-center justify-between p-4 hover:bg-indigo-50/40 transition-colors group">
                                                <div class="flex items-center gap-4 flex-1">
                                                    <div class="flex-shrink-0">
                                                        @if($isFlatCompleted)
                                                            <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-sm">
                                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                                </svg>
                                                            </div>
                                                        @else
                                                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-100 transition-colors shadow-sm">
                                                                <span class="text-sm font-bold text-gray-500 group-hover:text-indigo-600 transition-colors">{{ $loop->iteration }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <h4 class="font-semibold text-gray-900 group-hover:text-indigo-700 transition-colors text-sm">{{ $lesson->title }}</h4>
                                                        @if($lesson->duration_minutes)
                                                            <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                <span>{{ $lesson->formatted_duration }}</span>
                                                                @if($isFlatCompleted)
                                                                    <span class="px-1.5 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-semibold">Completed</span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <a href="{{ route('learn.lessons.show', $lesson) }}"
                                                    class="flex-shrink-0 ml-3 inline-flex items-center gap-1.5 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-200 shadow-sm
                                                    {{ $isFlatCompleted
                                                        ? 'bg-gray-100 text-gray-600 border border-gray-200 hover:bg-indigo-50 hover:text-indigo-600'
                                                        : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                                                    @if($isFlatCompleted)
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                        Review
                                                    @else
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Start Lesson
                                                    @endif
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Tests & Quick Stats -->
                <div class="space-y-6">

                    <!-- Tests Card -->
                    @if($course->tests->isNotEmpty())
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden sticky top-24">
                            <div class="px-5 py-4 bg-amber-50 border-b border-amber-100 flex items-center gap-3">
                                <div class="w-9 h-9 bg-amber-500 rounded-xl flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-sm">Course Tests</h3>
                                    <p class="text-xs text-gray-500">{{ $course->tests->count() }} test{{ $course->tests->count() > 1 ? 's' : '' }} available</p>
                                </div>
                            </div>
                            <div class="p-4 space-y-3">
                                @foreach($course->tests->sortBy('order') as $test)
                                    @php
                                        $progressTest = $enrollment->progress ?? [];
                                        $completedTests = $progressTest['completed_tests'] ?? [];
                                        $testCompleted = in_array($test->id, $completedTests);
                                    @endphp
                                    <div class="border border-gray-100 rounded-xl p-4 hover:border-amber-200 transition-colors">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="flex-shrink-0 w-9 h-9 {{ $testCompleted ? 'bg-emerald-500' : 'bg-amber-500' }} rounded-lg flex items-center justify-center shadow-sm">
                                                @if($testCompleted)
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-bold text-gray-900 text-sm">{{ $test->title }}</h4>
                                                <div class="flex items-center gap-3 text-xs text-gray-500 mt-0.5">
                                                    <span>{{ $test->questions->count() }} Questions</span>
                                                    <span>Pass: {{ $test->passing_score }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('tests.start', $test) }}"
                                            class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-lg font-semibold text-sm transition-all duration-200 shadow-sm
                                            {{ $testCompleted ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-amber-500 text-white hover:bg-amber-600' }}">
                                            {{ $testCompleted ? 'Retake Test' : 'Start Test' }}
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quick Stats Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
                        <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Quick Stats
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-gray-600">Total Lessons</span>
                                <span class="font-bold text-gray-900">{{ $course->lessons->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-gray-600">Completed</span>
                                <span class="font-bold text-emerald-600">{{ count($enrollment->progress['completed_lessons'] ?? []) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-gray-600">Tests</span>
                                <span class="font-bold text-gray-900">{{ $course->tests->count() }}</span>
                            </div>
                            @if($course->category)
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600">Category</span>
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-xs font-semibold">{{ $course->category }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>