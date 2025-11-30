<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-700 dark:to-purple-700 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">
                            Welcome back, <span class="text-indigo-200">{{ auth()->user()->name }}</span>! 👋
                        </h1>
                        <p class="text-indigo-100 text-lg">
                            You're logged in as a 
                            <span class="font-semibold bg-white/20 px-3 py-1 rounded-full">
                                {{ ucfirst(auth()->user()->roles?->first()?->name ?? 'user') }}
                            </span>
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-32 h-32 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-6">
            <!-- Student Dashboard -->
            @if(auth()->user()->hasRole('student'))
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- My Courses -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">My Courses</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                    {{ auth()->user()->enrollments()->count() }}
                                </span>
                            </div>
                            <a href="{{ route('enrollments.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 font-medium hover:text-indigo-700 dark:hover:text-indigo-300 flex items-center group-hover:translate-x-1 transition-transform duration-300">
                                View all courses
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Available Courses -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Available</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                    {{ App\Models\Course::published()->count() }}
                                </span>
                            </div>
                            <a href="{{ route('courses.browse') }}" class="text-sm text-green-600 dark:text-green-400 font-medium hover:text-green-700 dark:hover:text-green-300 flex items-center group-hover:translate-x-1 transition-transform duration-300">
                                Browse catalog
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Completed Courses -->
                    @php
                        $completedCount = auth()->user()->enrollments()->whereJsonLength('progress->completed_tests', '>', 0)->count();
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">In Progress</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                    {{ $completedCount }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Keep learning!
                            </p>
                        </div>
                    </div>

                    <!-- Certificates -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Certificates</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                    0
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Complete courses to earn
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Continue Learning Section -->
                @php
                    $enrolledCourses = auth()->user()->enrollments()->with('course.lessons', 'course.tests')->latest()->take(3)->get();
                @endphp

                @if($enrolledCourses->count() > 0)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Continue Learning</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($enrolledCourses as $enrollment)
                                @php
                                    $course = $enrollment->course;
                                    $progress = $course->getProgressFor(auth()->user());
                                @endphp
                                <a href="{{ route('enrollments.show', $course) }}" class="group">
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
                                        <!-- Course Image Placeholder -->
                                        <div class="h-48 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center">
                                            <svg class="w-24 h-24 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                            </svg>
                                        </div>
                                        <div class="p-6">
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                                {{ $course->title }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                                {{ $course->description }}
                                            </p>
                                            
                                            <!-- Progress Bar -->
                                            <div class="mb-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progress</span>
                                                    <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ $progress }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2.5 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                                <span>📚 {{ $course->lessons->count() }} Lessons</span>
                                                <span>📝 {{ $course->tests->count() }} Tests</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl p-8 border border-indigo-100 dark:border-indigo-800">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('courses.browse') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-xl hover:shadow-lg transition-all duration-300 group">
                            <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-lg group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">Explore Courses</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Find new courses</p>
                            </div>
                        </a>

                        <a href="{{ route('enrollments.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-xl hover:shadow-lg transition-all duration-300 group">
                            <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">My Courses</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Continue learning</p>
                            </div>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-xl hover:shadow-lg transition-all duration-300 group">
                            <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">My Profile</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Update settings</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Tutor Dashboard -->
            @if(auth()->user()->hasRole('tutor'))
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- My Courses -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">My Courses</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                    {{ auth()->user()->courses()->count() }}
                                </span>
                            </div>
                            <a href="{{ route('courses.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 font-medium hover:text-indigo-700 dark:hover:text-indigo-300 flex items-center group-hover:translate-x-1 transition-transform duration-300">
                                Manage courses
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Total Students -->
                    @php
                        $totalStudents = \App\Models\Enrollment::whereIn('course_id', auth()->user()->courses->pluck('id'))->distinct('user_id')->count('user_id');
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Students</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                    {{ $totalStudents }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Total enrollments
                            </p>
                        </div>
                    </div>

                    <!-- Published Courses -->
                    @php
                        $publishedCount = auth()->user()->courses()->where('is_published', true)->count();
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Published</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                    {{ $publishedCount }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Live courses
                            </p>
                        </div>
                    </div>

                    <!-- Create Course CTA -->
                    <a href="{{ route('courses.create') }}" class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                        <div class="p-6 h-full flex flex-col justify-center items-center text-center">
                            <div class="p-3 bg-white/20 rounded-xl mb-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <p class="text-white font-bold text-lg mb-1">Create Course</p>
                            <p class="text-indigo-100 text-sm">Start a new course</p>
                        </div>
                    </a>
                </div>

                <!-- Recent Courses -->
                @php
                    $recentCourses = auth()->user()->courses()->latest()->take(3)->get();
                @endphp

                @if($recentCourses->count() > 0)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recent Courses</h2>
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentCourses as $course)
                                    <a href="{{ route('courses.show', $course) }}" class="block p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors mb-2">
                                                    {{ $course->title }}
                                                </h4>
                                                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                        </svg>
                                                        {{ $course->lessons->count() }} lessons
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                        {{ $course->tests->count() }} tests
                                                    </span>
                                                    @if($course->is_published)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                            Published
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                            Draft
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Editor Dashboard -->
            @if(auth()->user()->hasRole('editor'))
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="p-4 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Editor Dashboard</h3>
                                <p class="text-gray-600 dark:text-gray-400">Manage tutor applications and platform content</p>
                            </div>
                        </div>
                        <a href="{{ route('editor.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            Manage Tutor Applications
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
