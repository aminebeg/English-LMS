<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Course Header -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden mb-6">
                <!-- Thumbnail Banner -->
                @if($course->thumbnail)
                    <div class="relative h-64 md:h-96 overflow-hidden">
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                            alt="{{ $course->title }}" 
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        
                        <!-- Overlay Info -->
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                            <div class="flex gap-2 mb-4">
                                @if($course->is_featured)
                                    <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">⭐ Featured</span>
                                @endif
                                @if(!$course->is_published)
                                    <span class="px-3 py-1 bg-gray-500 text-white text-xs font-bold rounded-full">Draft</span>
                                @else
                                    <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">✓ Published</span>
                                @endif
                            </div>
                            
                            <h1 class="text-4xl md:text-5xl font-bold mb-2">{{ $course->title }}</h1>
                            
                            @if($course->category)
                                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-full">
                                    {{ $course->category }}
                                </span>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="relative h-48 bg-gradient-to-br from-indigo-500 to-purple-600 p-8">
                        <div class="flex gap-2 mb-4">
                            @if($course->is_featured)
                                <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">⭐ Featured</span>
                            @endif
                            @if(!$course->is_published)
                                <span class="px-3 py-1 bg-gray-500 text-white text-xs font-bold rounded-full">Draft</span>
                            @else
                                <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">✓ Published</span>
                            @endif
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">{{ $course->title }}</h1>
                        
                        @if($course->category)
                            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-full">
                                {{ $course->category }}
                            </span>
                        @endif
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 p-6 border-b border-gray-200 dark:border-gray-700">
                    <a href="{{ route('courses.edit', $course) }}" 
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Course
                    </a>
                    <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>

                <!-- Course Info Grid -->
                <div class="p-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-1">
                                @if($course->price == 0)
                                    FREE
                                @else
                                    ${{ number_format($course->final_price, 2) }}
                                @endif
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Price</div>
                            @if($course->discount_percentage > 0)
                                <div class="text-xs text-red-600 dark:text-red-400 mt-1">
                                    {{ $course->discount_percentage }}% off
                                </div>
                            @endif
                        </div>

                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-1">
                                {{ $course->level ?? 'N/A' }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">CEFR Level</div>
                        </div>

                        @if($course->duration_weeks)
                            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div class="text-3xl font-bold text-pink-600 dark:text-pink-400 mb-1">
                                    {{ $course->duration_weeks }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Weeks</div>
                            </div>
                        @endif

                        @if($course->estimated_hours)
                            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-1">
                                    {{ $course->estimated_hours }}h
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Total Hours</div>
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">About This Course</h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $course->description }}</p>
                    </div>

                    <!-- Learning Outcomes -->
                    @if($course->learning_outcomes && count($course->learning_outcomes) > 0)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">What You'll Learn</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($course->learning_outcomes as $outcome)
                                    <div class="flex items-start gap-3 p-4 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                        <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $outcome }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Prerequisites -->
                    @if($course->prerequisites && count($course->prerequisites) > 0)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Prerequisites</h2>
                            <div class="space-y-3">
                                @foreach($course->prerequisites as $prerequisite)
                                    <div class="flex items-start gap-3 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl">
                                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $prerequisite }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Tags -->
                    @if($course->tags && count($course->tags) > 0)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tags</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($course->tags as $tag)
                                    <span class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm font-semibold rounded-full">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Additional Details -->
                    <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Course Details</h3>
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-400">Target Audience</dt>
                                    <dd class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($course->type) }}</dd>
                                </div>
                                @if($course->difficulty)
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600 dark:text-gray-400">Difficulty</dt>
                                        <dd class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($course->difficulty) }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <dt class="text-gray-600 dark:text-gray-400">Language</dt>
                                    <dd class="font-semibold text-gray-900 dark:text-white">{{ $course->language ?? 'English' }}</dd>
                                </div>
                                @if($course->max_students)
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600 dark:text-gray-400">Max Students</dt>
                                        <dd class="font-semibold text-gray-900 dark:text-white">{{ $course->max_students }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Course Features</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center gap-2">
                                    @if($course->has_certificate)
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">Certificate of Completion</span>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-500 dark:text-gray-400">No Certificate</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($course->has_payment_plan)
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">Payment Plan Available</span>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-500 dark:text-gray-400">No Payment Plan</span>
                                    @endif
                                </div>
                                @if($course->certificate_template)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"/>
                                            <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">{{ ucfirst($course->certificate_template) }} Template</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Instructor Bio -->
                    @if($course->instructor_bio)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">About the Instructor</h2>
                            <div class="p-6 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $course->instructor_bio }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Course Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Lessons -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">📚 Lessons</h2>
                            <a href="{{ route('lessons.create', ['course' => $course->id]) }}" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Add Lesson
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if($course->lessons->isEmpty())
                            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <p class="font-semibold">No lessons yet</p>
                                <p class="text-sm mt-1">Start building your course content</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($course->lessons as $lesson)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <span class="flex-shrink-0 w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                                {{ $lesson->order }}
                                            </span>
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $lesson->title }}</span>
                                        </div>
                                        <a href="{{ route('lessons.show', $lesson) }}" 
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-semibold">
                                            View →
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tests -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">📝 Tests</h2>
                            <a href="{{ route('tests.create', ['course' => $course->id]) }}" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Add Test
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if($course->tests->isEmpty())
                            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="font-semibold">No tests yet</p>
                                <p class="text-sm mt-1">Add assessments to evaluate students</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($course->tests as $test)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                        <div>
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $test->title }}</span>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                Passing Score: {{ $test->passing_score }}%
                                            </p>
                                        </div>
                                        <a href="{{ route('tests.show', $test) }}" 
                                            class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 font-semibold">
                                            View →
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
