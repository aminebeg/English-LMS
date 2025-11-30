<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <!-- Hero Header -->
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-700 dark:via-purple-700 dark:to-pink-700 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Explore Our Courses 🎓</h1>
                <p class="text-xl text-indigo-100">Discover the perfect course to advance your English learning journey</p>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6">
                <form method="GET" action="{{ route('courses.browse') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Search Courses
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    placeholder="Search by title, description..." 
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all"
                                >
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Level Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Level
                            </label>
                            <select 
                                name="level" 
                                class="w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all"
                            >
                                <option value="">All Levels</option>
                                <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>

                        <!-- Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type
                            </label>
                            <select 
                                name="type" 
                                class="w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all"
                            >
                                <option value="">All Types</option>
                                <option value="adult" {{ request('type') == 'adult' ? 'selected' : '' }}>Adult</option>
                                <option value="kid" {{ request('type') == 'kid' ? 'selected' : '' }}>Kid</option>
                                <option value="researcher" {{ request('type') == 'researcher' ? 'selected' : '' }}>Researcher</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button 
                            type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 hover:scale-105"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Search
                        </button>
                        
                        @if(request('search') || request('level') || request('type'))
                            <a 
                                href="{{ route('courses.browse') }}" 
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Courses Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if($courses->isEmpty())
                <div class="text-center py-16">
                    <div class="inline-block p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-lg">
                        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No courses found</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Try adjusting your search or filters</p>
                        <a href="{{ route('courses.browse') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all">
                            View All Courses
                        </a>
                    </div>
</div>
            @else
                <!-- Results Count -->
                <div class="mb-6">
                    <p class="text-lg text-gray-700 dark:text-gray-300">
                        Found <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $courses->total() }}</span> courses
                    </p>
                </div>

                <!-- Course Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($courses as $course)
                        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
                            <!-- Course Image -->
                            <div class="relative h-56 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 overflow-hidden">
                                <!-- Overlay Pattern -->
                                <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,<svg width=&quot;60&quot; height=&quot;60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;><path d=&quot;M0 0h60v60H0z&quot; fill=&quot;none&quot;/><path d=&quot;M30 0l30 30-30 30L0 30z&quot; fill=&quot;%23fff&quot; fill-opacity=&quot;.1&quot;/></svg>');"></div>
                                
                                <!-- Icon Overlay -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-32 h-32 text-white opacity-30 group-hover:scale-110 transition-transform duration-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                    </svg>
                                </div>

                                <!-- Badges -->
                                <div class="absolute top-4 left-4 flex gap-2">
                                    <span class="px-3 py-1 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm text-indigo-600 dark:text-indigo-400 text-xs font-bold rounded-full shadow-lg">
                                        {{ ucfirst($course->type) }}
                                    </span>
                                    @if($course->level)
                                        <span class="px-3 py-1 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm text-green-600 dark:text-green-400 text-xs font-bold rounded-full shadow-lg">
                                            {{ ucfirst($course->level) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Price Badge -->
                                <div class="absolute top-4 right-4">
                                    @if($course->price > 0)
                                        <span class="px-4 py-2 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm text-gray-900 dark:text-white font-bold rounded-full shadow-lg text-lg">
                                            ${{ number_format($course->price, 2) }}
                                        </span>
                                    @else
                                        <span class="px-4 py-2 bg-green-500/90 backdrop-blur-sm text-white font-bold rounded-full shadow-lg">
                                            FREE
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Course Content -->
                            <div class="p-6">
                                <!-- Title -->
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2">
                                    {{ $course->title }}
                                </h3>

                                <!-- Description -->
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed">
                                    {{ $course->description }}
                                </p>

                                <!-- Tutor Info -->
                                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($course->tutor->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Instructor</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $course->tutor->name }}</p>
                                    </div>
                                </div>

                                <!-- Course Stats -->
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span class="font-medium">{{ $course->lessons->count() }} Lessons</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="font-medium">{{ $course->tests->count() }} Tests</span>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                @if($course->isEnrolledBy(auth()->user()))
                                    <a 
                                        href="{{ route('enrollments.show', $course) }}" 
                                        class="block w-full text-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-xl hover:shadow-lg transition-all duration-300 hover:scale-105"
                                    >
                                        Continue Learning →
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-lg transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2 group"
                                        >
                                            <span>Enroll Now</span>
                                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $courses->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
