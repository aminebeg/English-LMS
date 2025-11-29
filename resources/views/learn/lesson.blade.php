<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $lesson->title }}
                </h2>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ $course->title }} • Lesson {{ $lesson->order }}
                </div>
            </div>
            <a href="{{ route('enrollments.show', $course) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Back to Course
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Lesson Content -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100 prose dark:prose-invert max-w-none">
                            {!! nl2br(e($lesson->content)) !!}
                        </div>
                    </div>

                    <!-- Materials -->
                    @if($materials->isNotEmpty())
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Course Materials</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($materials as $material)
                                        <div class="border dark:border-gray-700 rounded-lg p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                            <div class="flex items-center gap-3">
                                                <div class="text-2xl">
                                                    @if($material->type === 'pdf') 📄
                                                    @elseif($material->type === 'video') 🎥
                                                    @elseif($material->type === 'audio') 🎵
                                                    @else 📎
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $material->title }}</h4>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($material->type) }}</p>
                                                </div>
                                            </div>
                                            <a href="{{ $material->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                                View
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation & Completion -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 flex items-center justify-between">
                            <!-- Previous Lesson -->
                            @php
                                $prevLesson = $course->lessons->where('order', '<', $lesson->order)->sortByDesc('order')->first();
                                $nextLesson = $course->lessons->where('order', '>', $lesson->order)->sortBy('order')->first();
                            @endphp

                            <div>
                                @if($prevLesson)
                                    <a href="{{ route('learn.lessons.show', $prevLesson) }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        Previous Lesson
                                    </a>
                                @endif
                            </div>

                            <!-- Mark Complete Button -->
                            <form method="POST" action="{{ $isCompleted ? route('learn.lessons.incomplete', $lesson) : route('learn.lessons.complete', $lesson) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md font-semibold text-sm uppercase tracking-widest transition ease-in-out duration-150 {{ $isCompleted ? 'bg-green-100 text-green-800 hover:bg-green-200 border-green-200' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                                    @if($isCompleted)
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Completed
                                    @else
                                        Mark as Complete
                                    @endif
                                </button>
                            </form>

                            <!-- Next Lesson -->
                            <div>
                                @if($nextLesson)
                                    <a href="{{ route('learn.lessons.show', $nextLesson) }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        Next Lesson
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Course Progress -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Course Content</h3>
                            <div class="space-y-1 max-h-[calc(100vh-300px)] overflow-y-auto pr-2">
                                @foreach($course->lessons->sortBy('order') as $l)
                                    @php
                                        $enrollment = $course->getEnrollmentFor(auth()->user());
                                        $progress = $enrollment->progress ?? [];
                                        $lCompleted = in_array($l->id, $progress['completed_lessons'] ?? []);
                                        $isActive = $l->id === $lesson->id;
                                    @endphp
                                    
                                    <a href="{{ route('learn.lessons.show', $l) }}" class="flex items-center p-2 rounded-md transition {{ $isActive ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300' : 'hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                                        <div class="flex-shrink-0 mr-3">
                                            @if($lCompleted)
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <div class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded-full"></div>
                                            @endif
                                        </div>
                                        <span class="text-sm font-medium truncate">{{ $l->order }}. {{ $l->title }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
