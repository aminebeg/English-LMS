<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Message -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        You're logged in as a <strong>{{ ucfirst(auth()->user()->roles->first()->name ?? 'user') }}</strong>
                    </p>
                </div>
            </div>

            <!-- Student Dashboard -->
            @if(auth()->user()->hasRole('student'))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- My Courses Card -->
                    <a href="{{ route('enrollments.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">My Courses</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ auth()->user()->enrollments()->count() }}
                                    </p>
                                </div>
                                <div class="text-4xl">📚</div>
                            </div>
                        </div>
                    </a>

                    <!-- Browse Courses Card -->
                    <a href="{{ route('courses.browse') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Available Courses</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ App\Models\Course::published()->count() }}
                                    </p>
                                </div>
                                <div class="text-4xl">🔍</div>
                            </div>
                        </div>
                    </a>

                    <!-- Profile Card -->
                    <a href="{{ route('profile.edit') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Profile</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Edit Profile</p>
                                </div>
                                <div class="text-4xl">👤</div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            <!-- Tutor Dashboard -->
            @if(auth()->user()->hasRole('tutor'))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- My Courses Card -->
                    <a href="{{ route('courses.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">My Courses</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ auth()->user()->courses()->count() }}
                                    </p>
                                </div>
                                <div class="text-4xl">📚</div>
                            </div>
                        </div>
                    </a>

                    <!-- Create Course Card -->
                    <a href="{{ route('courses.create') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">New Course</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Create Course</p>
                                </div>
                                <div class="text-4xl">➕</div>
                            </div>
                        </div>
                    </a>

                    <!-- Profile Card -->
                    <a href="{{ route('profile.edit') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Profile</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Edit Profile</p>
                                </div>
                                <div class="text-4xl">👤</div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Recent Courses -->
                @php
                    $recentCourses = auth()->user()->courses()->latest()->take(5)->get();
                @endphp

                @if($recentCourses->count() > 0)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Recent Courses</h3>
                            <div class="space-y-2">
                                @foreach($recentCourses as $course)
                                    <a href="{{ route('courses.show', $course) }}" class="flex items-center justify-between p-3 border dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $course->title }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $course->lessons->count() }} lessons • {{ $course->tests->count() }} tests
                                                @if($course->is_published)
                                                    <span class="text-green-600 dark:text-green-400">• Published</span>
                                                @else
                                                    <span class="text-yellow-600 dark:text-yellow-400">• Draft</span>
                                                @endif
                                            </p>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Editor Dashboard -->
            @if(auth()->user()->hasRole('editor'))
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Editor Dashboard</h3>
                        <a href="{{ route('editor.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Manage Tutor Applications
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
