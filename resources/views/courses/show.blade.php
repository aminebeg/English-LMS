<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $course->title }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                            by {{ $course->tutor->name }}
                            @if($course->category)
                                • {{ $course->category }}
                            @endif
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    @if(auth()->id() === $course->tutor_id)
                        <div class="flex gap-3 items-center">
                            <a href="{{ route('enrollments.show', $course) }}"
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors text-sm shadow-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Preview as Student
                            </a>
                            <a href="{{ route('courses.edit', $course) }}"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors text-sm shadow-sm">
                                Edit Course
                            </a>
                            <form method="POST" action="{{ route('courses.destroy', $course) }}"
                                onsubmit="return confirm('Delete this course?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Badges -->
                <div class="flex gap-2 mt-4">
                    @if($course->is_featured)
                        <span
                            class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded">Featured</span>
                    @endif
                    @if($course->is_published)
                        <span
                            class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">Published</span>
                    @else
                        <span
                            class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded">Draft</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Course Info -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">
                                    @if($course->price == 0)
                                        FREE
                                    @else
                                        ${{ number_format($course->final_price, 2) }}
                                    @endif
                                </div>
                                <div class="text-sm text-gray-600">Price</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $course->lessons->count() }}
                                </div>
                                <div class="text-sm text-gray-600">Lessons</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $course->students->count() }}
                                </div>
                                <div class="text-sm text-gray-600">Students</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $course->level ?? 'All' }}
                                </div>
                                <div class="text-sm text-gray-600">Level</div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">About This Course</h2>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>

                    <!-- Learning Outcomes -->
                    @if($course->learning_outcomes && count($course->learning_outcomes) > 0)
                        <div
                            class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">What You'll Learn</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($course->learning_outcomes as $outcome)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ $outcome }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Course Content -->
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Course Curriculum
                            </h2>
                            @if(auth()->id() === $course->tutor_id)
                                <div class="flex gap-2">
                                    <button
                                        onclick="document.getElementById('add-section-modal').classList.remove('hidden')"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                        + Section
                                    </button>
                                    <span class="text-gray-300">|</span>
                                    <a href="{{ route('lessons.create', ['course' => $course->id]) }}"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                        + Lesson
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="p-0">
                            @if($course->sections->isNotEmpty())
                                <div class="divide-y divide-gray-100">
                                    @foreach($course->sections as $section)
                                        <div class="bg-white">
                                            <!-- Section Toggle -->
                                            <div
                                                class="px-6 py-4 bg-gray-50 flex items-center justify-between border-b border-gray-100">
                                                <div class="flex items-center gap-3">
                                                    <span
                                                        class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                                        {{ $loop->iteration }}
                                                    </span>
                                                    <div>
                                                        <h3 class="font-bold text-gray-900">
                                                            {{ $section->title }}
                                                        </h3>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $section->lessons->count() }} lessons •
                                                            {{ $section->tests->count() }} tests
                                                        </p>
                                                    </div>
                                                </div>
                                                @if(auth()->id() === $course->tutor_id)
                                                    <div class="flex items-center gap-3">
                                                        <a href="{{ route('lessons.create', ['course' => $course->id, 'course_section_id' => $section->id]) }}"
                                                            class="text-xs font-medium text-indigo-600 hover:text-indigo-700 transition-colors"
                                                            title="Add Lesson to Section">+ Lesson</a>
                                                        <span class="text-gray-300">|</span>
                                                        <a href="{{ route('tests.create', ['course' => $course->id, 'course_section_id' => $section->id]) }}"
                                                            class="text-xs text-gray-500 hover:text-indigo-600 transition-colors"
                                                            title="Add Test to Section">+ Test</a>
                                                        <span class="text-gray-300">|</span>
                                                        <button onclick="editSection({{ $section->id }}, '{{ addslashes($section->title) }}', '{{ addslashes($section->description) }}')"
                                                            class="text-xs text-gray-500 hover:text-indigo-600 transition-colors"
                                                            title="Edit Section">Edit</button>
                                                        <span class="text-gray-300">|</span>
                                                        <form method="POST" action="{{ route('sections.destroy', $section) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this section?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition-colors" title="Delete Section">Delete</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Section Lessons & Tests -->
                                            <div class="divide-y divide-gray-50">
                                                @foreach($section->lessons as $lesson)
                                                    <div
                                                        class="px-6 py-4 hover:bg-gray-50 transition flex items-center justify-between group">
                                                        <div class="flex items-center gap-4">
                                                            <svg class="w-5 h-5 group-hover:text-indigo-500 transition-colors"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <div>
                                                                <a href="{{ route('lessons.show', $lesson) }}"
                                                                    class="text-sm font-medium text-gray-900 hover:text-indigo-600 transition-colors">
                                                                    {{ $lesson->title }}
                                                                </a>
                                                                <div class="flex items-center gap-2 mt-1">
                                                                    @if($lesson->is_preview)
                                                                        <span
                                                                            class="text-[10px] px-1.5 py-0.5 bg-green-100 text-green-700 font-bold rounded">PREVIEW</span>
                                                                    @endif
                                                                    <span
                                                                        class="text-[10px]">{{ $lesson->duration_minutes ?? '10' }}
                                                                        mins</span>
                                                                    @if($lesson->tests->isNotEmpty())
                                                                        <span
                                                                            class="text-[10px] bg-yellow-100 text-yellow-700 px-1 py-0.5 rounded">{{ $lesson->tests->count() }}
                                                                            Quiz</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(auth()->id() === $course->tutor_id)
                                                            <div
                                                                class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity items-center">
                                                                <a href="{{ route('lessons.edit', $lesson) }}"
                                                                    class="text-[10px] px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition-colors">Edit</a>
                                                                <form method="POST" action="{{ route('lessons.destroy', $lesson) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-[10px] px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded transition-colors">Delete</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach

                                                @foreach($section->tests as $test)
                                                    <div
                                                        class="px-6 py-4 bg-amber-50 flex items-center justify-between">
                                                        <div class="flex items-center gap-4">
                                                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            <div>
                                                                <span
                                                                    class="text-sm font-bold text-gray-900">{{ $test->title }}</span>
                                                                <p class="text-[10px] text-gray-500">Section Test •
                                                                    {{ $test->questions->count() }} Questions
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('tests.show', $test) }}"
                                                            class="text-xs font-semibold text-indigo-600 hover:underline">Manage</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                    @php
                                        $orphanedLessons = $course->lessons->whereNull('course_section_id')->sortBy('order');
                                    @endphp
                                    @if($orphanedLessons->isNotEmpty())
                                        <div class="bg-white">
                                            <div
                                                class="px-6 py-3 bg-gray-100/50 border-b border-gray-700">
                                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Unassigned
                                                    Lessons</h3>
                                            </div>
                                            <div class="divide-y divide-gray-700">
                                                @foreach($orphanedLessons as $lesson)
                                                    <div
                                                        class="px-6 py-4 hover:bg-gray-50 transition flex items-center justify-between group">
                                                        <div class="flex items-center gap-4">
                                                            <svg class="w-5 h-5 group-hover:text-indigo-500 transition-colors"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <div>
                                                                <a href="{{ route('lessons.show', $lesson) }}"
                                                                    class="text-sm font-medium text-gray-900">
                                                                    {{ $lesson->title }}
                                                                </a>
                                                                <div class="flex items-center gap-2 mt-1">
                                                                    @if($lesson->is_preview)
                                                                        <span
                                                                            class="text-[10px] px-1.5 py-0.5 bg-green-100 text-green-700 font-bold rounded">PREVIEW</span>
                                                                    @endif
                                                                    <span
                                                                        class="text-[10px]">{{ $lesson->duration_minutes ?? '10' }}
                                                                        mins</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(auth()->id() === $course->tutor_id)
                                                            <div
                                                                class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity items-center">
                                                                <a href="{{ route('lessons.edit', $lesson) }}"
                                                                    class="text-[10px] px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition-colors">Edit</a>
                                                                <form method="POST" action="{{ route('lessons.destroy', $lesson) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-[10px] px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded transition-colors">Delete</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="divide-y divide-gray-100">
                                    @forelse($course->lessons->sortBy('order') as $lesson)
                                        <div
                                            class="px-6 py-5 hover:bg-gray-50 transition flex items-center justify-between group">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold">
                                                    {{ $lesson->order }}
                                                </div>
                                                <div>
                                                    <a href="{{ route('lessons.show', $lesson) }}"
                                                        class="text-base font-bold text-gray-900 hover:text-indigo-600 transition-colors">
                                                        {{ $lesson->title }}
                                                    </a>
                                                    <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                                                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg> {{ $lesson->duration_minutes ?? '10' }} min</span>
                                                        @if($lesson->is_preview)
                                                            <span
                                                                class="text-[10px] px-2 py-0.5 bg-green-100 text-green-700 font-bold rounded">FREE
                                                                PREVIEW</span>
                                                        @endif
                                                        @if($lesson->tests->isNotEmpty())
                                                            <span
                                                                class="flex items-center gap-1 text-yellow-600 font-medium">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                </svg>
                                                                {{ $lesson->tests->count() }} Quiz
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if(auth()->id() === $course->tutor_id)
                                                <div
                                                    class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <a href="{{ route('lessons.edit', $lesson) }}"
                                                        class="px-3 py-1 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Edit</a>
                                                    <form method="POST" action="{{ route('lessons.destroy', $lesson) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1 bg-red-50 border border-red-200 rounded-md text-xs font-semibold text-red-600 hover:bg-red-100 transition-colors">Delete</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="text-center py-20 text-gray-500">
                                            <div
                                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <p class="text-lg font-medium">No curriculum content yet.</p>
                                            @if(auth()->id() === $course->tutor_id)
                                                <a href="{{ route('lessons.create', ['course' => $course->id]) }}"
                                                    class="mt-4 inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-bold text-sm">Add
                                                    Your First Lesson</a>
                                            @endif
                                        </div>
                                    @endforelse
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Final Exams / Course Level Tests -->
                    @if($course->tests->whereNull('course_section_id')->whereNull('lesson_id')->isNotEmpty())
                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-6 h-6 text-purple-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Final Exams & Assessments
                                </h2>
                                @if(auth()->id() === $course->tutor_id)
                                    <a href="{{ route('tests.create', ['course' => $course->id]) }}"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                        + Add Final Exam</a>
                                @endif
                            </div>

                            <div class="space-y-3">
                                @foreach($course->tests->whereNull('course_section_id')->whereNull('lesson_id') as $test)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-transparent hover:border-indigo-200 transition-all group">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center">
                                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900">{{ $test->title }}</h4>
                                                <div class="flex items-center gap-3 mt-0.5 text-xs text-gray-500">
                                                    <span>{{ $test->questions->count() }} Questions</span>
                                                    <span>Passing Score: {{ $test->passing_score }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('tests.show', $test) }}"
                                            class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all shadow-sm">Manage</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Sidebar -->
                <div class="space-y-6">

                    <!-- Media -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="aspect-video bg-gray-900 relative group">
                            @if($course->preview_video)
                                @php
                                    $videoUrl = $course->preview_video;
                                    $embedUrl = '';
                                    if (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
                                        $embedUrl = str_replace(['watch?v=', 'youtu.be/'], ['embed/', 'www.youtube.com/embed/'], $videoUrl);
                                        if (str_contains($embedUrl, '&')) {
                                            $embedUrl = explode('&', $embedUrl)[0];
                                        }
                                    } elseif (str_contains($videoUrl, 'vimeo.com')) {
                                        $embedUrl = str_replace('vimeo.com/', 'player.vimeo.com/video/', $videoUrl);
                                    }
                                @endphp

                                @if($embedUrl)
                                    <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                @else
                                    <video src="{{ asset('storage/' . $videoUrl) }}" controls class="w-full h-full"></video>
                                @endif
                            @elseif($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-indigo-600">
                                    <svg class="w-16 h-16 opacity-50" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Course Details -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Course Details</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $course->estimated_hours ?? 0 }}h</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Level</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $course->level ?? 'All Levels' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Language</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $course->language ?? 'English' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Certificate</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $course->has_certificate ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Updated</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $course->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Instructor</h3>
                        <div class="flex  items-start gap-4">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-lg font-bold text-indigo-600">
                                {{ substr($course->tutor->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $course->tutor->name }}</div>
                                <div class="text-sm text-gray-600">
                                    {{ $course->tutor->courses->count() }} courses
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($course->tags && count($course->tags) > 0)
                        <div
                            class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($course->tags as $tag)
                                    <span
                                        class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Add Section Modal -->
    <div id="add-section-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('add-section-modal').classList.add('hidden')"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('courses.sections.store', $course) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start w-full">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Add New Section
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-700">Section Title</label>
                                        <input type="text" name="title" id="title" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Add Section
                        </button>
                        <button type="button" onclick="document.getElementById('add-section-modal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function editSection(id, title, description) {
        // Find the modal
        const modal = document.getElementById('add-section-modal');
        const form = modal.querySelector('form');
        const titleInput = document.getElementById('title');
        const descInput = document.getElementById('description');
        const modalTitle = document.getElementById('modal-title');
        const submitBtn = form.querySelector('button[type="submit"]');

        // Update form action and method to PUT
        form.action = `/sections/${id}`;
        
        let methodInput = form.querySelector('input[name="_method"]');
        if(!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            form.appendChild(methodInput);
        }
        methodInput.value = 'PUT';

        // Set values
        titleInput.value = title;
        descInput.value = description;
        
        // Update UI
        modalTitle.textContent = 'Edit Section';
        submitBtn.textContent = 'Save Changes';

        // Show modal
        modal.classList.remove('hidden');
    }

    // Reset modal when closing
    document.getElementById('add-section-modal').addEventListener('click', function(e) {
        if(e.target === this || e.target.closest('button[type="button"]')) {
            const form = this.querySelector('form');
            form.action = "{{ route('courses.sections.store', $course) }}";
            const methodInput = form.querySelector('input[name="_method"]');
            if(methodInput) methodInput.remove();
            
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            document.getElementById('modal-title').textContent = 'Add New Section';
            form.querySelector('button[type="submit"]').textContent = 'Add Section';
        }
    });
</script>
