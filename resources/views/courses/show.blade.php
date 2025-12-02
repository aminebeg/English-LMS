<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">{{ $course->title }}</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
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
                            <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Delete this course?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                
                <!-- Badges -->
                <div class="flex gap-2 mt-4">
                    @if($course->is_featured)
                        <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 text-xs font-medium rounded">Featured</span>
                    @endif
                    @if($course->is_published)
                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-xs font-medium rounded">Published</span>
                    @else
                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 text-xs font-medium rounded">Draft</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Course Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                    @if($course->price == 0)
                                        FREE
                                    @else
                                        ${{ number_format($course->final_price, 2) }}
                                    @endif
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Price</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $course->lessons->count() }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Lessons</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $course->students->count() }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Students</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $course->level ?? 'All' }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Level</div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">About This Course</h2>
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>

                    <!-- Learning Outcomes -->
                    @if($course->learning_outcomes && count($course->learning_outcomes) > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">What You'll Learn</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($course->learning_outcomes as $outcome)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $outcome }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Course Content -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Course Content</h2>
                            <a href="{{ route('lessons.create', ['course' => $course->id]) }}" 
                                class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                                + Add Lesson
                            </a>
                        </div>
                        
                        <div class="space-y-2">
                            @forelse($course->lessons->sortBy('order') as $lesson)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded text-xs font-medium">
                                            {{ $lesson->order }}
                                        </span>
                                        <a href="{{ route('lessons.show', $lesson) }}" class="text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400">
                                            {{ $lesson->title }}
                                        </a>
                                        @if($lesson->is_preview)
                                            <span class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">Preview</span>
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $lesson->duration_minutes ?? '10' }} min</span>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    No lessons yet. <a href="{{ route('lessons.create', ['course' => $course->id]) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Add your first lesson</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tests -->
                    @if($course->tests &&$course->tests->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Tests & Quizzes</h2>
                                <a href="{{ route('tests.create', ['course' => $course->id]) }}" 
                                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                                    + Add Test
                                </a>
                            </div>
                            
                            <div class="space-y-2">
                                @foreach($course->tests as $test)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                        <span class="text-gray-900 dark:text-white">{{ $test->title }}</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $test->questions->count() }} questions</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Thumbnail -->
                    @if($course->thumbnail)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full aspect-video object-cover">
                        </div>
                    @endif

                    <!-- Course Details -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Course Details</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Duration</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $course->estimated_hours ?? 0 }}h</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Level</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $course->level ?? 'All Levels' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Language</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $course->language ?? 'English' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Certificate</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $course->has_certificate ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Updated</span>
                                <span class="text-gray-900 dark:text-white font-medium">{{ $course->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Instructor</h3>
                        <div class="flex  items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                {{ substr($course->tutor->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $course->tutor->name }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $course->tutor->courses->count() }} courses</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($course->tags && count($course->tags) > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($course->tags as $tag)
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
