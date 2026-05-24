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
                        <div class="flex gap-3">
                            <a href="{{ route('courses.edit', $course) }}"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
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
                            class="px-2 py-1 bg-yellow-100 bg-yellow-900/30 text-yellow-800 text-yellow-300 text-xs font-medium rounded">Featured</span>
                    @endif
                    @if($course->is_published)
                        <span
                            class="px-2 py-1 bg-green-100 bg-green-900/30 text-green-800 text-green-300 text-xs font-medium rounded">Published</span>
                    @else
                        <span
                            class="px-2 py-1 bg-gray-100 bg-gray-700 text-gray-800 text-gray-300 text-xs font-medium rounded">Draft</span>
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
                            class="px-6 py-4 border-b border-gray-200 bg-gray-50/50 bg-gray-800/50 flex items-center justify-between">
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
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700 text-indigo-400 hover:text-indigo-300">
                                        + Section
                                    </button>
                                    <span class="text-gray-300">|</span>
                                    <a href="{{ route('lessons.create', ['course' => $course->id]) }}"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700 text-indigo-400 hover:text-indigo-300">
                                        + Lesson
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="p-0">
                            @if($course->sections->isNotEmpty())
                                <div class="divide-y divide-gray-200 divide-gray-700">
                                    @foreach($course->sections as $section)
                                        <div class="bg-white">
                                            <!-- Section Toggle -->
                                            <div
                                                class="px-6 py-4 bg-gray-50/30 bg-gray-700/20 flex items-center justify-between border-b border-gray-700">
                                                <div class="flex items-center gap-3">
                                                    <span
                                                        class="w-8 h-8 rounded-lg bg-indigo-100 bg-indigo-900/30 flex items-center justify-center text-indigo-600 text-indigo-400 font-bold text-sm">
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
                                                    <div class="flex items-center gap-2">
                                                        <a href="{{ route('tests.create', ['course' => $course->id, 'course_section_id' => $section->id]) }}"
                                                            class="text-xs text-gray-500 hover:text-indigo-600 transition-colors"
                                                            title="Add Test to Section">+ Test</a>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Section Lessons & Tests -->
                                            <div class="divide-y divide-gray-50 divide-gray-700/50">
                                                @foreach($section->lessons as $lesson)
                                                    <div
                                                        class="px-6 py-4 hover:bg-gray-50/50 hover:bg-gray-700/10 transition flex items-center justify-between group">
                                                        <div class="flex items-center gap-4">
                                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500 transition-colors"
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
                                                                            class="text-[10px] px-1.5 py-0.5 bg-green-100 bg-green-900/30 text-green-700 text-green-400 font-bold rounded">PREVIEW</span>
                                                                    @endif
                                                                    <span
                                                                        class="text-[10px] text-gray-400">{{ $lesson->duration_minutes ?? '10' }}
                                                                        mins</span>
                                                                    @if($lesson->tests->isNotEmpty())
                                                                        <span
                                                                            class="text-[10px] bg-yellow-100 bg-yellow-900/30 text-yellow-700 text-yellow-400 px-1 py-0.5 rounded">{{ $lesson->tests->count() }}
                                                                            Quiz</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(auth()->id() === $course->tutor_id)
                                                            <div
                                                                class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                                <a href="{{ route('tests.create', ['course' => $course->id, 'lesson_id' => $lesson->id]) }}"
                                                                    class="text-[10px] text-indigo-600 hover:underline">+ Test</a>
                                                                <a href="{{ route('lessons.edit', $lesson) }}"
                                                                    class="text-[10px] text-gray-400 hover:text-gray-600">Edit</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach

                                                @foreach($section->tests as $test)
                                                    <div
                                                        class="px-6 py-4 bg-yellow-50/30 bg-yellow-900/10 flex items-center justify-between">
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
                                                class="px-6 py-3 bg-gray-100/50 bg-gray-700/50 border-b border-gray-700">
                                                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Unassigned
                                                    Lessons</h3>
                                            </div>
                                            <div class="divide-y divide-gray-700">
                                                @foreach($orphanedLessons as $lesson)
                                                    <div
                                                        class="px-6 py-4 hover:bg-gray-50/50 hover:bg-gray-700/10 transition flex items-center justify-between group">
                                                        <div class="flex items-center gap-4">
                                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500 transition-colors"
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
                                                                            class="text-[10px] px-1.5 py-0.5 bg-green-100 bg-green-900/30 text-green-700 text-green-400 font-bold rounded">PREVIEW</span>
                                                                    @endif
                                                                    <span
                                                                        class="text-[10px] text-gray-400">{{ $lesson->duration_minutes ?? '10' }}
                                                                        mins</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(auth()->id() === $course->tutor_id)
                                                            <div
                                                                class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                                <a href="{{ route('lessons.edit', $lesson) }}"
                                                                    class="text-[10px] text-gray-400 hover:text-gray-600">Edit</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="divide-y divide-gray-100 divide-gray-700">
                                    @forelse($course->lessons->sortBy('order') as $lesson)
                                        <div
                                            class="px-6 py-5 hover:bg-gray-50 hover:bg-gray-700/30 transition flex items-center justify-between group">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-indigo-50 bg-indigo-900/20 flex items-center justify-center text-indigo-600 text-indigo-400 font-bold">
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
                                                                class="text-[10px] px-2 py-0.5 bg-green-100 bg-green-900/30 text-green-700 text-green-400 font-bold rounded">FREE
                                                                PREVIEW</span>
                                                        @endif
                                                        @if($lesson->tests->isNotEmpty())
                                                            <span
                                                                class="flex items-center gap-1 text-yellow-600 text-yellow-400 font-medium">
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
                                                </div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="text-center py-20 text-gray-500">
                                            <div
                                                class="w-16 h-16 bg-gray-100 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
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
                                    <svg class="w-6 h-6 text-purple-600 text-purple-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Final Exams & Assessments
                                </h2>
                                @if(auth()->id() === $course->tutor_id)
                                    <a href="{{ route('tests.create', ['course' => $course->id]) }}"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700 text-indigo-400 hover:text-indigo-300">+
                                        Add Final Exam</a>
                                @endif
                            </div>

                            <div class="space-y-3">
                                @foreach($course->tests->whereNull('course_section_id')->whereNull('lesson_id') as $test)
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 bg-gray-700/30 rounded-xl border border-transparent hover:border-indigo-200 hover:border-indigo-800 transition-all group">
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
                                            class="px-4 py-2 bg-white border border-gray-200 border-gray-600 rounded-lg text-sm font-bold text-gray-700 hover:bg-indigo-50 hover:bg-indigo-900/40 hover:text-indigo-600 hover:text-indigo-400 transition-all shadow-sm">Manage</a>
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
                                    <svg class="w-16 h-16 text-indigo-400 opacity-50" fill="currentColor"
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
                                class="flex-shrink-0 w-12 h-12 bg-indigo-100 bg-indigo-900/30 rounded-full flex items-center justify-center text-lg font-bold text-indigo-600 text-indigo-400">
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
                                        class="px-2 py-1 bg-gray-100 bg-gray-700 text-gray-700 text-xs rounded">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

