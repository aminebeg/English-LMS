<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->title }} - {{ config('app.name') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">English LMS</span>
                </a>
                
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 font-medium transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 font-medium transition">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition shadow-lg">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Course Hero -->
    <section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white pt-16 pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2">
                    <!-- Course Title -->
                    <div class="flex gap-3 mb-4">
                        <span class="px-4 py-1 bg-white/20 backdrop-blur-sm text-white text-sm font-bold rounded-full">
                            {{ ucfirst($course->type) }}
                        </span>
                        @if($course->level)
                            <span class="px-4 py-1 bg-white/20 backdrop-blur-sm text-white text-sm font-bold rounded-full">
                                {{ ucfirst($course->level) }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-5xl font-bold mb-6">{{ $course->title }}</h1>
                    <p class="text-xl text-indigo-100 mb-8 leading-relaxed">{{ $course->description }}</p>

                    <!-- Course Stats -->
                    <div class="flex flex-wrap gap-6 mb-8">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="font-semibold">{{ $totalLessonsCount }} Lessons</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="font-semibold">{{ $course->tests->count() }} Tests</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span class="font-semibold">{{ $previewLessonsCount }} Free Previews</span>
                        </div>
                    </div>

                    <!-- Instructor -->
                    <div class="flex items-center gap-4 p-6 bg-white/10 backdrop-blur-sm rounded-2xl">
                        <div class="w-16 h-16 bg-white/30 rounded-full flex items-center justify-center text-2xl font-bold">
                            {{ strtoupper(substr($course->tutor->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm text-indigo-200">Taught by</p>
                            <p class="text-xl font-bold">{{ $course->tutor->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Enrollment Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 sticky top-24">
                        <div class="text-center mb-6">
                            @if($course->price > 0)
                                <div class="text-5xl font-bold text-gray-900 dark:text-white mb-2">
                                    ${{ number_format($course->price, 2) }}
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">One-time payment</p>
                            @else
                                <div class="text-5xl font-bold text-green-600 dark:text-green-400 mb-2">
                                    FREE
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">Full access</p>
                            @endif
                        </div>

                        @guest
                            <a href="{{ route('register') }}" class="block w-full text-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-lg transition-all duration-300 hover:scale-105 mb-3">
                                Sign Up to Enroll
                            </a>
                            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">Log in</a>
                            </p>
                        @else
                            @if($course->isEnrolledBy(auth()->user()))
                                <a href="{{ route('enrollments.show', $course) }}" class="block w-full text-center px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-xl hover:shadow-lg transition-all duration-300 hover:scale-105">
                                    Continue Learning →
                                </a>
                            @else
                                <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                    @csrf
                                    <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-lg transition-all duration-300 hover:scale-105">
                                        Enroll Now
                                    </button>
                                </form>
                            @endif
                        @endauth

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">This course includes:</p>
                            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <li class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Lifetime access
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $totalLessonsCount }} video lessons
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $course->tests->count() }} quizzes
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Certificate of completion
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Content -->
    <section class="relative -mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 md:p-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Course Curriculum</h2>

                @if($course->lessons->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400 text-center py-12">
                        Curriculum coming soon...
                    </p>
                @else
                    <div class="space-y-3">
                        @foreach($course->lessons as $index => $lesson)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden hover:border-indigo-300 dark:hover:border-indigo-600 transition">
                                <div class="flex items-center justify-between p-5 bg-gray-50 dark:bg-gray-700/50">
                                    <div class="flex items-center gap-4 flex-1">
                                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 dark:text-white text-lg">
                                                {{ $lesson->title }}
                                            </h3>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        @if($lesson->is_preview)
                                            <span class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-sm font-semibold rounded-full">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Free Preview
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-full">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Locked
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($course->tests->isNotEmpty())
                    <div class="mt-12">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Tests & Assessments</h3>
                        <div class="space-y-3">
                            @foreach($course->tests as $index => $test)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-5 bg-gray-50 dark:bg-gray-700/50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $test->title }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">Passing score: {{ $test->passing_score }}%</p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-full">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Locked
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white mt-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Start Learning?</h2>
            <p class="text-xl mb-10 text-indigo-100">
                {{ $previewLessonsCount > 0 ? "Try {$previewLessonsCount} free preview lessons first!" : "Enroll now and start mastering English!" }}
            </p>
            @guest
                <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-indigo-600 font-bold rounded-xl hover:bg-gray-100 transition shadow-2xl text-lg">
                    Create Free Account
                </a>
            @else
                @if(!$course->isEnrolledBy(auth()->user()))
                    <form method="POST" action="{{ route('courses.enroll', $course) }}" class="inline-block">
                        @csrf
                        <button type="submit" class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-xl hover:bg-gray-100 transition shadow-2xl text-lg">
                            Enroll in This Course
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-500 text-sm">© {{ date('Y') }} English LMS. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
