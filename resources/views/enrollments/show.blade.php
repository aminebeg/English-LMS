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

            <!-- Course Content -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-gray-100 mb-8 flex items-center gap-3">
                        <span class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200 dark:shadow-none">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </span>
                        Course Syllabus
                    </h3>
                    
                    @if($course->sections->isNotEmpty())
                        <div class="space-y-6">
                            @foreach($course->sections as $section)
                                <div class="border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-md">
                                    <div class="bg-gray-50/50 dark:bg-gray-800/50 px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center cursor-pointer group">
                                        <div>
                                            <h4 class="font-black text-lg text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">{{ $section->title }}</h4>
                                            @if($section->description)
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $section->description }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-white dark:bg-gray-700 text-gray-500 shadow-sm border dark:border-gray-600">
                                                {{ $section->lessons->count() }} Lessons
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="divide-y divide-gray-50 dark:divide-gray-700/50 bg-white dark:bg-gray-800">
                                        <!-- Lessons -->
                                        @foreach($section->lessons as $lesson)
                                            @php
                                                $progressArr = $enrollment->progress ?? [];
                                                $completedLessons = $progressArr['completed_lessons'] ?? [];
                                                $isCompleted = in_array($lesson->id, $completedLessons);
                                            @endphp
                                            <div class="flex items-center justify-between p-5 hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-all group">
                                                <div class="flex items-center gap-5">
                                                    <div class="flex-shrink-0">
                                                        @if($isCompleted)
                                                            <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center shadow-lg shadow-green-100 dark:shadow-none">
                                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            </div>
                                                        @else
                                                            <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center text-gray-400 dark:text-gray-500 font-black text-sm group-hover:bg-indigo-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-indigo-100 dark:group-hover:shadow-none transition-all">
                                                                {{ $loop->iteration }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h5 class="font-bold text-gray-900 dark:text-gray-100 text-lg">{{ $lesson->title }}</h5>
                                                        <div class="flex items-center gap-4 mt-1">
                                                            @if($lesson->duration_minutes)
                                                                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                    {{ $lesson->formatted_duration }}
                                                                </span>
                                                            @endif
                                                            @if($lesson->tests->isNotEmpty())
                                                                <span class="text-[10px] bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 px-2 py-0.5 rounded font-black">
                                                                    {{ $lesson->tests->count() }} QUIZ
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="{{ route('learn.lessons.show', $lesson) }}" class="flex-shrink-0 ml-4 px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-100 dark:shadow-none opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                                    {{ $isCompleted ? 'Review' : 'Start' }}
                                                </a>
                                            </div>
                                        @endforeach

                                        <!-- Section Tests -->
                                        @foreach($section->tests as $test)
                                            @php
                                                $progressArr = $enrollment->progress ?? [];
                                                $completedTestsArr = $progressArr['completed_tests'] ?? [];
                                                $isCompleted = in_array($test->id, $completedTestsArr);
                                            @endphp
                                            <div class="flex items-center justify-between p-5 bg-yellow-50/30 dark:bg-yellow-900/5 group">
                                                <div class="flex items-center gap-5">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-10 h-10 {{ $isCompleted ? 'bg-green-500' : 'bg-yellow-500' }} rounded-xl flex items-center justify-center shadow-lg shadow-yellow-100 dark:shadow-none">
                                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-black text-gray-900 dark:text-gray-100">{{ $test->title }}</h5>
                                                        <p class="text-xs text-yellow-700 dark:text-yellow-400 font-bold">Section Final Test • {{ $test->questions->count() }} Questions</p>
                                                    </div>
                                                </div>
                                                <a href="{{ route('tests.start', $test) }}" class="flex-shrink-0 ml-4 px-6 py-2.5 bg-yellow-500 text-white rounded-xl text-sm font-black shadow-lg shadow-yellow-100 dark:shadow-none">
                                                    {{ $isCompleted ? 'Retake' : 'Start Test' }}
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
                                <div class="pt-4">
                                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 ml-2">General Lessons</h4>
                                    <div class="border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden shadow-sm">
                                        <div class="divide-y divide-gray-50 dark:divide-gray-700/50 bg-white dark:bg-gray-800">
                                            @foreach($orphanedLessons as $lesson)
                                                @php
                                                    $progressArr = $enrollment->progress ?? [];
                                                    $completedLessonsArr = $progressArr['completed_lessons'] ?? [];
                                                    $isCompleted = in_array($lesson->id, $completedLessonsArr);
                                                @endphp
                                                <div class="flex items-center justify-between p-5 hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out group">
                                                    <div class="flex items-center gap-5">
                                                        <div class="flex-shrink-0">
                                                            @if($isCompleted)
                                                                <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center shadow-md shadow-green-100/50">
                                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                </div>
                                                            @else
                                                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center text-gray-400 dark:text-gray-500 font-black text-sm group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                                                    {{ $loop->iteration }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h5 class="font-bold text-gray-900 dark:text-gray-100 text-lg transition-colors group-hover:text-indigo-600">{{ $lesson->title }}</h5>
                                                            <div class="flex items-center gap-3">
                                                                @if($lesson->duration_minutes)
                                                                    <span class="text-xs text-gray-500 flex items-center gap-1">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                        {{ $lesson->formatted_duration }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('learn.lessons.show', $lesson) }}" class="flex-shrink-0 ml-4 px-6 py-2.5 bg-white dark:bg-gray-800 border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl text-sm font-black transition-all">
                                                        {{ $isCompleted ? 'Review' : 'Start' }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Flat List -->
                        <div class="border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden shadow-sm">
                            <div class="divide-y divide-gray-50 dark:divide-gray-700/50 bg-white dark:bg-gray-800">
                                @foreach($course->lessons->sortBy('order') as $lesson)
                                    @php
                                        $progressArr = $enrollment->progress ?? [];
                                        $completedLessonsArr = $progressArr['completed_lessons'] ?? [];
                                        $isCompleted = in_array($lesson->id, $completedLessonsArr);
                                    @endphp
                                    <div class="flex items-center justify-between p-5 hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition duration-150 ease-in-out group">
                                        <div class="flex items-center gap-5">
                                            <div class="flex-shrink-0">
                                                @if($isCompleted)
                                                    <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center shadow-lg shadow-green-100 dark:shadow-none">
                                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                @else
                                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center text-gray-400 dark:text-gray-500 font-black text-sm group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-md group-hover:shadow-indigo-100 dark:group-hover:shadow-none">
                                                        {{ $loop->iteration }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h5 class="font-black text-gray-900 dark:text-gray-100 text-lg transition-colors group-hover:text-indigo-600">{{ $lesson->title }}</h5>
                                                @if($lesson->duration_minutes)
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5 mt-1 font-bold">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        {{ $lesson->formatted_duration }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <a href="{{ route('learn.lessons.show', $lesson) }}" class="flex-shrink-0 ml-4 px-8 py-3 bg-indigo-600 text-white rounded-xl text-sm font-black shadow-lg shadow-indigo-100 dark:shadow-none transition-all transform group-hover:scale-105 active:scale-95">
                                            {{ $isCompleted ? 'Review' : 'Start' }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
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
                                    <a href="{{ route('tests.start', $test) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 text-sm">
                                        {{ $isCompleted ? 'Retake' : 'Start Test' }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
