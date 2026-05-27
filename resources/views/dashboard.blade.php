<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- ====== STUDENT DASHBOARD ====== --}}
            @if(auth()->user()->hasRole('student'))
                <div class="flex flex-col lg:flex-row gap-8">

                    <!-- Main Content: Enrolled Courses -->
                    <div class="lg:w-3/4">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">My Courses</h2>
                            <a href="{{ route('courses.browse') }}"
                                class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                                Explore New Courses &rarr;
                            </a>
                        </div>

                        @php
                            $enrollments = auth()->user()->enrollments()->with('course.tutor')->latest()->get();
                        @endphp

                        @if($enrollments->isEmpty())
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-10 text-center">
                                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No courses yet</h3>
                                <p class="text-sm text-gray-500 mb-6">You are not enrolled in any courses yet.</p>
                                <a href="{{ route('courses.browse') }}"
                                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 text-sm transition-colors shadow-sm">
                                    Browse Courses
                                </a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($enrollments as $enrollment)
                                    @php
                                        $course = $enrollment->course;
                                        $progress = $course->getProgressFor(auth()->user());
                                    @endphp
                                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col md:flex-row hover:shadow-md transition-shadow">
                                        <!-- Course Thumbnail -->
                                        <div class="md:w-56 h-36 md:h-auto bg-indigo-100 relative shrink-0 overflow-hidden">
                                            @if($course->thumbnail)
                                                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                    alt="{{ $course->title }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-400 to-indigo-600">
                                                    <svg class="w-12 h-12 text-white opacity-40" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Course Details -->
                                        <div class="p-5 flex-1 flex flex-col justify-between">
                                            <div>
                                                <div class="flex items-center justify-between mb-1.5">
                                                    <span class="text-xs font-semibold px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full">
                                                        {{ ucfirst($course->type) }}
                                                    </span>
                                                    <span class="text-xs text-gray-400">
                                                        Enrolled {{ $enrollment->created_at->format('M d, Y') }}
                                                    </span>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-900 mb-0.5">
                                                    <a href="{{ route('enrollments.show', $course) }}"
                                                        class="hover:text-indigo-600 transition-colors">
                                                        {{ $course->title }}
                                                    </a>
                                                </h3>
                                                <p class="text-sm text-gray-500 mb-4">by {{ $course->tutor->name }}</p>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-sm mb-1.5">
                                                    <span class="font-medium text-gray-700">Progress</span>
                                                    <span class="font-bold text-indigo-600">{{ $progress }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-100 rounded-full h-2 mb-4">
                                                    <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500"
                                                        style="width: {{ $progress }}%"></div>
                                                </div>
                                                <div class="flex justify-end">
                                                    <a href="{{ route('enrollments.show', $course) }}"
                                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white font-semibold text-sm rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                                        {{ $progress > 0 ? 'Resume Course' : 'Start Course' }}
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-1/4 space-y-5">
                        <!-- Profile Summary -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                            <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">My Account</h3>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-sm text-gray-900">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                                class="block w-full text-center px-4 py-2 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                                Edit Profile
                            </a>
                        </div>

                        <!-- Quick Links -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                            <h3 class="font-bold text-gray-900 mb-3 text-sm uppercase tracking-wide">Quick Links</h3>
                            <ul class="space-y-2 text-sm">
                                <li>
                                    <a href="{{ route('courses.browse') }}"
                                        class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        Find Courses
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('tests.my-results') }}"
                                        class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        My Test Results
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ====== TUTOR DASHBOARD ====== --}}
            @if(auth()->user()->hasRole('tutor'))
                <div class="flex flex-col lg:flex-row gap-8">

                    <!-- Main Content: Course Management -->
                    <div class="lg:w-3/4">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Instructor Dashboard</h2>
                            <a href="{{ route('courses.create') }}"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors text-sm shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create New Course
                            </a>
                        </div>

                        @php
                            $tutorCourses = auth()->user()->teachingCourses()->withCount('enrollments')->latest()->get();
                        @endphp

                        @if($tutorCourses->isEmpty())
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                                <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No courses yet</h3>
                                <p class="text-sm text-gray-500 mb-6 max-w-sm mx-auto">Start sharing your knowledge. Create your first course today.</p>
                                <a href="{{ route('courses.create') }}"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors shadow-sm text-sm">
                                    Create Course
                                </a>
                            </div>
                        @else
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-100">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Course</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Students</th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach($tutorCourses as $course)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center overflow-hidden">
                                                            @if($course->thumbnail)
                                                                <img class="w-10 h-10 object-cover rounded-lg"
                                                                    src="{{ asset('storage/' . $course->thumbnail) }}" alt="">
                                                            @else
                                                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-semibold text-gray-900">{{ $course->title }}</div>
                                                            <div class="text-xs text-gray-500">Created {{ $course->created_at->format('M d, Y') }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                        {{ $course->is_published ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $course->is_published ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                                                        {{ $course->is_published ? 'Published' : 'Draft' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                    {{ $course->enrollments_count }}
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <div class="flex items-center justify-end gap-3">
                                                        <a href="{{ route('courses.show', $course) }}"
                                                            class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">Manage</a>
                                                        <span class="text-gray-200">|</span>
                                                        <a href="{{ route('courses.edit', $course) }}"
                                                            class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Edit</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-1/4 space-y-5">
                        <!-- Overview Stats -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                            <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wide">Overview</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Total Students</span>
                                    <span class="font-bold text-gray-900 text-sm">
                                        {{ \App\Models\Enrollment::whereIn('course_id', auth()->user()->teachingCourses->pluck('id'))->distinct('user_id')->count('user_id') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Published Courses</span>
                                    <span class="font-bold text-gray-900 text-sm">
                                        {{ auth()->user()->teachingCourses()->where('is_published', true)->count() }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Total Courses</span>
                                    <span class="font-bold text-gray-900 text-sm">{{ $tutorCourses->count() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                            <h3 class="font-bold text-gray-900 mb-3 text-sm uppercase tracking-wide">Quick Actions</h3>
                            <ul class="space-y-2 text-sm">
                                <li>
                                    <a href="{{ route('courses.create') }}"
                                        class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Create New Course
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('courses.index') }}"
                                        class="flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        View All Courses
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ====== EDITOR DASHBOARD ====== --}}
            @if(auth()->user()->hasRole('editor'))
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-2xl">
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="p-4 bg-indigo-600 rounded-xl shadow-sm">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Editor Dashboard</h3>
                                <p class="text-sm text-gray-500">Manage tutor applications and platform content</p>
                            </div>
                        </div>
                        <a href="{{ route('editor.dashboard') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors text-sm shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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