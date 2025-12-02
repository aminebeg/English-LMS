<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'English LMS') }} - Learn English Online</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">English LMS</span>
                </div>
                
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:shadow-indigo-600/50 transform hover:-translate-y-0.5 transition-all duration-200">
                                    Get Started
                                </a>
                            @endif
                            <a href="{{ route('tutor.register.form') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-indigo-600 text-indigo-600 dark:text-indigo-400 font-semibold rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                Become a Tutor
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                    Master English with Expert Tutors
                </h1>
                <p class="text-xl md:text-2xl mb-10 text-gray-600 dark:text-gray-400 leading-relaxed">
                    Join thousands of students learning English online. Access quality courses from beginner to advanced levels.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#courses" class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:shadow-indigo-600/50 transform hover:-translate-y-0.5 transition-all duration-200 text-lg">
                        Explore Courses
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white font-bold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 text-lg">
                            Start Learning Free
                        </a>
                    @endguest
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-8 mt-16 max-w-2xl mx-auto">
                    <div>
                        <div class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">{{ \App\Models\Course::published()->count() }}+</div>
                        <div class="text-gray-600 dark:text-gray-400">Courses</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">{{ \App\Models\User::role('student')->count() }}+</div>
                        <div class="text-gray-600 dark:text-gray-400">Students</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">{{ \App\Models\User::role('tutor')->count() }}+</div>
                        <div class="text-gray-600 dark:text-gray-400">Tutors</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Courses -->
    @php
        $featuredCourses = \App\Models\Course::published()
            ->with(['tutor', 'lessons', 'tests'])
            ->latest()
            ->take(6)
            ->get();
    @endphp

    <section id="courses" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Featured Courses
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Start your learning journey with our most popular courses
                </p>
            </div>

            @if($featuredCourses->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Coming Soon!</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Our expert tutors are preparing amazing courses for you.</p>
                  @auth
                        @if(auth()->user()->hasRole('tutor'))
                            <a href="{{ route('courses.create') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition">
                                Create First Course
                            </a>
                        @endif
                    @else
                        <a href="{{ route('tutor.register.form') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition">
                            Become a Tutor
                        </a>
                    @endauth
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredCourses as $course)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-xl hover:border-indigo-200 dark:hover:border-indigo-800 transform hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
                            <!-- Course Image -->
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

                            <!-- Course Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                                    {{ $course->title }}
                                </h3>

                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                    {{ $course->description }}
                                </p>

                                <!-- Tutor Info -->
                                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                                        {{ strtoupper(substr($course->tutor->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Instructor</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $course->tutor->name }}</p>
                                    </div>
                                </div>

                                <!-- Course Stats -->
                                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    <span>{{ $course->lessons->count() }} lessons</span>
                                    <span>{{ $course->tests->count() }} tests</span>
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('courses.preview', $course) }}" class="block w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- View All Courses Button -->
                <div class="text-center mt-12">
                    @auth
                        <a href="{{ route('courses.browse') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 transition">
                            View All Courses
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 transition">
                            Sign Up to Browse All Courses
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Why Choose English LMS?
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    The best platform for learning English online
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 dark:bg-gray-900 p-8 rounded-lg">
                    <div class="w-16 h-16 bg-blue-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Expert Tutors</h3>
                    <p class="text-gray-600 dark:text-gray-400">Learn from certified English teachers with years of experience</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900 p-8 rounded-lg">
                    <div class="w-16 h-16 bg-purple-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Learn at Your Pace</h3>
                    <p class="text-gray-600 dark:text-gray-400">Study anytime, anywhere with flexible course schedules</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900 p-8 rounded-lg">
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Get Certified</h3>
                    <p class="text-gray-600 dark:text-gray-400">Earn certificates upon course completion to boost your career</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-indigo-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Ready to Start Learning?
            </h2>
            <p class="text-xl mb-10 text-indigo-100">
                Join thousands of students improving their English skills every day
            </p>
            @guest
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-indigo-600 font-bold rounded-md hover:bg-gray-100 transition">
                        Create Free Account
                    </a>
                    <a href="{{ route('tutor.register.form') }}" class="px-8 py-3 bg-transparent border-2 border-white text-white font-bold rounded-md hover:bg-white hover:text-indigo-600 transition">
                        Teach on English LMS
                    </a>
                </div>
            @else
                <a href="{{ route('courses.browse') }}" class="inline-block px-8 py-3 bg-white text-indigo-600 font-bold rounded-md hover:bg-gray-100 transition">
                    Browse All Courses
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <svg class="w-8 h-8 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                    <span class="text-2xl font-bold text-white">English LMS</span>
                </div>
                <p class="text-gray-400 mb-4">
                    Your premier online destination for mastering the English language
                </p>
                <p class="text-gray-500 text-sm">
                    © {{ date('Y') }} English LMS. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
