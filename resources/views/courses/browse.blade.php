<x-app-layout>
    <div class="min-h-screen bg-gray-50">

        <!-- Hero Header -->
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <h1 class="text-3xl font-bold text-gray-900">Browse Courses</h1>
                <p class="mt-1.5 text-gray-500">Discover the perfect course for your English learning journey</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Search & Filter -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-8">
                <form method="GET" action="{{ route('courses.browse') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Search</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search courses..."
                                    class="w-full pl-9 pr-4 py-2.5 rounded-lg border border-gray-200 text-gray-900 placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 focus:outline-none text-sm transition">
                            </div>
                        </div>

                        <!-- Level -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Level</label>
                            <select name="level"
                                class="w-full py-2.5 px-3 rounded-lg border border-gray-200 text-gray-900 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 focus:outline-none text-sm transition bg-white">
                                <option value="">All Levels</option>
                                <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Type</label>
                            <select name="type"
                                class="w-full py-2.5 px-3 rounded-lg border border-gray-200 text-gray-900 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 focus:outline-none text-sm transition bg-white">
                                <option value="">All Types</option>
                                <option value="adult" {{ request('type') == 'adult' ? 'selected' : '' }}>Adult</option>
                                <option value="kid" {{ request('type') == 'kid' ? 'selected' : '' }}>Kid</option>
                                <option value="researcher" {{ request('type') == 'researcher' ? 'selected' : '' }}>Researcher</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-4">
                        <button type="submit"
                            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors text-sm shadow-sm">
                            Search
                        </button>
                        @if (request()->hasAny(['search', 'level', 'type']))
                            <a href="{{ route('courses.browse') }}"
                                class="px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors text-sm">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @if ($courses->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">No courses found</h3>
                    <p class="text-sm text-gray-500 mb-6">Try adjusting your search filters</p>
                    <a href="{{ route('courses.browse') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors text-sm shadow-sm">
                        View All Courses
                    </a>
                </div>
            @else
                <!-- Results Count -->
                <div class="mb-5 flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Showing <span class="font-semibold text-gray-900">{{ $courses->total() }}</span> courses
                    </p>
                </div>

                <!-- Course Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach ($courses as $course)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden flex flex-col">
                            <!-- Thumbnail -->
                            <div class="aspect-video bg-indigo-100 flex items-center justify-center relative overflow-hidden">
                                @if ($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                        alt="{{ $course->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center">
                                        <svg class="w-14 h-14 text-white opacity-40" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- Badges overlay -->
                                <div class="absolute top-2.5 left-2.5 flex gap-1.5">
                                    <span class="px-2 py-1 bg-white/90 backdrop-blur-sm text-indigo-700 text-xs font-semibold rounded-md shadow-sm">
                                        {{ ucfirst($course->type) }}
                                    </span>
                                    @if ($course->level)
                                        <span class="px-2 py-1 bg-white/90 backdrop-blur-sm text-emerald-700 text-xs font-semibold rounded-md shadow-sm">
                                            {{ ucfirst($course->level) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Price badge -->
                                <div class="absolute top-2.5 right-2.5">
                                    @if ($course->price > 0)
                                        <span class="px-2.5 py-1 bg-gray-900/80 backdrop-blur-sm text-white font-bold text-sm rounded-md shadow-sm">
                                            ${{ number_format($course->price, 2) }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-emerald-500 text-white font-bold text-sm rounded-md shadow-sm">
                                            FREE
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="text-base font-bold text-gray-900 mb-1.5 line-clamp-2 leading-snug">
                                    {{ $course->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2 leading-relaxed flex-1">
                                    {{ $course->description }}
                                </p>

                                <!-- Tutor -->
                                <div class="flex items-center gap-2.5 mb-4 pb-4 border-b border-gray-100">
                                    <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($course->tutor->name, 0, 1)) }}
                                    </div>
                                    <div class="text-sm text-gray-600 truncate">{{ $course->tutor->name }}</div>
                                </div>

                                <!-- Stats -->
                                <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        {{ $course->lessons->count() }} lessons
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ $course->tests->count() }} tests
                                    </span>
                                </div>

                                <!-- Action -->
                                @auth
                                    @if ($course->isEnrolledBy(auth()->user()))
                                        <a href="{{ route('enrollments.show', $course) }}"
                                            class="block w-full text-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors text-sm shadow-sm">
                                            Continue Learning →
                                        </a>
                                    @else
                                        <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors text-sm shadow-sm">
                                                Enroll Now
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block w-full text-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors text-sm shadow-sm">
                                        Login to Enroll
                                    </a>
                                @endauth
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
