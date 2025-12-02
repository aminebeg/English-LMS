<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Browse Courses</h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">Discover the perfect course for your learning journey</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Search & Filter -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
                <form method="GET" action="{{ route('courses.browse') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses..."
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <!-- Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level</label>
                            <select name="level" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Levels</option>
                                <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>
                        
                        <!-- Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                            <select name="type" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Types</option>
                                <option value="adult" {{ request('type') == 'adult' ? 'selected' : '' }}>Adult</option>
                                <option value="kid" {{ request('type') == 'kid' ? 'selected' : '' }}>Kid</option>
                                <option value="researcher" {{ request('type') == 'researcher' ? 'selected' : '' }}>Researcher</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                            Search
                        </button>
                        @if(request()->hasAny(['search', 'level', 'type']))
                            <a href="{{ route('courses.browse') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @if($courses->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No courses found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search filters</p>
                    <div class="mt-6">
                        <a href="{{ route('courses.browse') }}" class="inline-flex items-center px-4 py 2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                            View All Courses
                        </a>
                    </div>
                </div>
            @else
                <!-- Results Count -->
                <div class="mb-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Found <span class="font-semibold text-gray-900 dark:text-white">{{ $courses->total() }}</span> courses
                    </p>
                </div>

                <!-- Course Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($courses as $course)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow overflow-hidden">
                            <!-- Thumbnail -->
                            <div class="aspect-video bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center relative">
                               @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-16 h-16 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                    </svg>
                                @endif
                                
                                <!-- Badges -->
                                <div class="absolute top-2 left-2 flex gap-2">
                                    <span class="px-2 py-1 bg-white dark:bg-gray-900 text-indigo-600 dark:text-indigo-400 text-xs font-medium rounded">
                                        {{ ucfirst($course->type) }}
                                    </span>
                                    @if($course->level)
                                        <span class="px-2 py-1 bg-white dark:bg-gray-900 text-green-600 dark:text-green-400 text-xs font-medium rounded">
                                            {{ ucfirst($course->level) }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Price -->
                                <div class="absolute top-2 right-2">
                                    @if($course->price > 0)
                                        <span class="px-3 py-1 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-bold text-sm rounded">
                                            ${{ number_format($course->price, 2) }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-green-500 text-white font-bold text-sm rounded">
                                            FREE
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                    {{ $course->title }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                    {{ $course->description }}
                                </p>
                                
                                <!-- Tutor -->
                                <div class="flex items-center gap-2 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-semibold text-sm">
                                        {{ strtoupper(substr($course->tutor->name, 0, 1)) }}
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $course->tutor->name }}
                                    </div>
                                </div>
                                
                                <!-- Stats -->
                                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    <span>{{ $course->lessons->count() }} lessons</span>
                                    <span>{{ $course->tests->count() }} tests</span>
                                </div>
                                
                                <!-- Action -->
                                @if($course->isEnrolledBy(auth()->user()))
                                    <a href="{{ route('enrollments.show', $course) }}" class="block w-full text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                                        Continue Learning
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                                            Enroll Now
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div>
                    {{ $courses->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
