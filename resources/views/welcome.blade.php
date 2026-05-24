<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'English LMS') }} - Master English with Expert Tutors</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
            }

            50% {
                box-shadow: 0 0 40px rgba(99, 102, 241, 0.8);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .gradient-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #4facfe);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-8px);
        }

        .shine {
            position: relative;
            overflow: hidden;
        }

        .shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .shine:hover::before {
            left: 100%;
        }
    </style>
</head>

<body class="antialiased bg-gray-50">
    {{-- Navigation --}}
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-200 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <div>
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">English
                            LMS</span>
                        <p class="text-xs text-gray-500">Learn. Practice. Master.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-5 py-2.5 text-hover:text-indigo-600 font-medium transition-all">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-5 py-2.5 text-hover:text-indigo-600 font-medium transition-all">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                    Get Started Free
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 md:pt-40 md:pb-32 overflow-hidden">
        {{-- Animated Background --}}
        <div class="absolute inset-0 gradient-bg opacity-10"></div>

        {{-- Floating Elements --}}
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float">
        </div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"
            style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"
            style="animation-delay: 4s;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 rounded-full mb-8">
                    <span class="relative flex h-3 w-3">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                    </span>
                    <span class="text-sm font-semibold text-indigo-600">Join
                        {{ \App\Models\User::role('student')->count() }}+ Active Learners</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-extrabold text-mb-8 leading-tight">
                    Master English with
                    <span
                        class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                        Expert Tutors
                    </span>
                </h1>

                <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-8">
                    Transform your English skills with personalized courses and interactive learning experiences.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                    <a href="#courses"
                        class="group px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-2xl hover:shadow-indigo-500/50 transform hover:-translate-y-1 transition-all duration-200 text-lg shine">
                        <span class="flex items-center justify-center gap-2">
                            Explore Courses
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </span>
                    </a>
                    @guest
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 bg-white border-2 border-gray-300 text-font-bold rounded-xl hover:border-indigo-500 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-lg">
                            Start Learning Free
                        </a>
                    @endguest
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-8 max-w-3xl mx-auto">
                    <div class="text-center">
                        <div
                            class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                            {{ \App\Models\Course::published()->count() }}+
                        </div>
                        <div class="text-sm md:text-base text-gray-600 font-medium">Expert Courses
                        </div>
                    </div>
                    <div class="text-center">
                        <div
                            class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                            {{ \App\Models\User::role('tutor')->count() }}+
                        </div>
                        <div class="text-sm md:text-base text-gray-600 font-medium">Certified Tutors
                        </div>
                    </div>
                    <div class="text-center">
                        <div
                            class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-pink-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                            {{ \App\Models\User::role('student')->count() }}+
                        </div>
                        <div class="text-sm md:text-base text-gray-600 font-medium">Happy Students
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Courses --}}
    @php
        $featuredCourses = \App\Models\Course::published()
            ->with(['tutor', 'lessons', 'tests'])
            ->latest()
            ->take(6)
            ->get();
    @endphp

    <section id="courses" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-2 bg-indigo-100 text-indigo-600 rounded-full text-sm font-semibold mb-4">
                    FEATURED COURSES
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-mb-4">
                    Start Your Learning Journey
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Choose from our most popular courses designed by expert tutors
                </p>
            </div>

            @if ($featuredCourses->isEmpty())
                <div
                    class="text-center py-20 bg-gray-50 bg-rounded-2xl border-2 border-dashed border-gray-300 border->
                    <div
                        class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-mb-3">Amazing Courses Coming Soon!</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Our expert tutors are preparing
                        incredible courses for you.</p>
                    @auth
                        @if (auth()->user()->hasRole('tutor'))
                            <a href="{{ route('courses.create') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Create First Course
                            </a>
                        @endif
                    @else
                        <a href="{{ route('tutor.register.form') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                            Become a Tutor
                        </a>
                    @endauth
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($featuredCourses as $course)
                        <div
                            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl border border-gray-200 overflow-hidden hover-lift">
                            {{-- Course Image --}}
                            <div
                                class="relative aspect-video bg-gradient-to-br from-indigo-500 to-purple-600 overflow-hidden">
                                @if ($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Badges --}}
                                <div class="absolute top-3 left-3 flex gap-2">
                                    <span
                                        class="px-3 py-1 bg-white/90 bg-gray-900/90 backdrop-blur-sm text-indigo-600 text-xs font-bold rounded-full">
                                        {{ ucfirst($course->type) }}
                                    </span>
                                    @if ($course->level)
                                        <span
                                            class="px-3 py-1 bg-white/90 bg-gray-900/90 backdrop-blur-sm text-green-600 text-xs font-bold rounded-full">
                                            {{ ucfirst($course->level) }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Price --}}
                                <div class="absolute top-3 right-3">
                                    @if ($course->price> 0)
                                        <span
                                            class="px-4 py-2 bg-white bg-text-font-bold text-lg rounded-full shadow-lg">
                                            ${{ number_format($course->price, 2) }}
                                        </span>
                                    @else
                                        <span
                                            class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-bold text-lg rounded-full shadow-lg">
                                            FREE
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Course Content --}}
                            <div class="p-6">
                                <h3
                                    class="text-xl font-bold text-mb-3 line-clamp-2 group-hover:text-indigo-600 group-hover:transition-colors">
                                    {{ $course->title }}
                                </h3>

                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $course->description }}
                                </p>

                                {{-- Tutor Info --}}
                                <div
                                    class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                        {{ strtoupper(substr($course->tutor->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Instructor</p>
                                        <p class="text-sm font-semibold text->
                                            {{ $course->tutor->name }}</p>
                                    </div>
                                </div>

                                {{-- Course Stats --}}
                                <div
                                    class="flex items-center justify-between text-sm text-gray-600 mb-5">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        {{ $course->lessons->count() }} lessons
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        {{ $course->tests->count() }} tests
                                    </span>
                                </div>

                                {{-- Action Button --}}
                                <a href="{{ route('courses.preview', $course) }}"
                                    class="block w-full text-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- View All Button --}}
                <div class="text-center mt-12">
                    @auth
                        <a href="{{ route('courses.browse') }}"
                            class="inline-flex items-center gap-2 px-8 py-4 bg-bg-white text-white text-font-bold rounded-xl hover:shadow-xl transition-all">
                            View All Courses
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center gap-2 px-8 py-4 bg-bg-white text-white text-font-bold rounded-xl hover:shadow-xl transition-all">
                            Sign Up to Browse All Courses
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </section>



    {{-- Features Section --}}
    <section class="py-20 bg-white bg->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-2 bg-green-100 bg-text-green-600 rounded-full text-sm font-semibold mb-4">
                    WHY CHOOSE US
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-mb-4">
                    Everything You Need to Succeed
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    The most comprehensive platform for learning English online
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="group p-8 bg-gradient-to-br from-blue-50 to-indigo-50 from-to-rounded-2xl hover:shadow-xl transition-all hover-lift">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-mb-3">Expert Tutors</h3>
                    <p class="text-gray-600">Learn from certified English teachers with years of
                        experience and proven teaching methods.</p>
                </div>

                <div
                    class="group p-8 bg-gradient-to-br from-purple-50 to-pink-50 from-to-pink-900/20 rounded-2xl hover:shadow-xl transition-all hover-lift">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-mb-3">Interactive Learning</h3>
                    <p class="text-gray-600">Engage with dynamic lessons, quizzes, and multimedia
                        content to master English effectively.</p>
                </div>

                <div
                    class="group p-8 bg-gradient-to-br from-green-50 to-emerald-50 from-green-900/20 to-emerald-900/20 rounded-2xl hover:shadow-xl transition-all hover-lift">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-mb-3">Get Certified</h3>
                    <p class="text-gray-600">Earn certificates upon course completion to showcase
                        your skills and boost your career.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600"></div>
        <div class="absolute inset-0 opacity-10">
            <div
                class="absolute top-10 left-10 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-float">
            </div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-float"
                style="animation-delay: 2s;"></div>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Ready to Start Your Journey?
            </h2>
            <p class="text-xl mb-10 text-indigo-100">
                Join thousands of students improving their English skills every day
            </p>
            @guest
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                        class="px-10 py-4 bg-white text-indigo-600 font-bold rounded-xl hover:bg-gray-100 shadow-2xl hover:shadow-white/50 transition-all text-lg">
                        Create Free Account
                    </a>
                    <a href="{{ route('tutor.register.form') }}"
                        class="px-10 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white hover:text-indigo-600 transition-all text-lg">
                        Teach on English LMS
                    </a>
                </div>
            @else
                <a href="{{ route('courses.browse') }}"
                    class="inline-block px-10 py-4 bg-white text-indigo-600 font-bold rounded-xl hover:bg-gray-100 shadow-2xl hover:shadow-white/50 transition-all text-lg">
                    Browse All Courses
                </a>
            @endauth
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-white">English LMS</span>
                </div>
                <p class= mb-6 max-w-md mx-auto">
                    Your premier online destination for mastering the English language with expert tutors and
                    interactive learning.
                </p>
                <div class="flex items-center justify-center gap-6 mb-6">
                    <a href="#" class= hover:text-white transition-colors">About</a>
                    <a href="#" class= hover:text-white transition-colors">Contact</a>
                    <a href="#" class= hover:text-white transition-colors">Privacy</a>
                    <a href="#" class= hover:text-white transition-colors">Terms</a>
                </div>
                <p class="text-gray-500 text-sm">
                    © {{ date('Y') }} English LMS. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>

</html>

