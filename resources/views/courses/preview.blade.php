<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->title }} - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/preview.css'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Outfit', sans-serif;
        }

        .premium-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dark .glass-card {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }
    </style>
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="sticky top-0 z-[100] bg-white/70 dark:bg-gray-900/70 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-black text-gray-900 dark:text-white block leading-none">English LMS</span>
                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">Mastery</span>
                    </div>
                </a>

                <div class="flex items-center gap-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-black text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors uppercase tracking-widest">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-black text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors uppercase tracking-widest">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-black text-sm rounded-xl hover:shadow-xl transition-all uppercase tracking-widest hover:-translate-y-0.5">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Course Hero -->
    <section class="relative pt-12 pb-24 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-gray-50 dark:bg-gray-900"></div>
        <div
            class="absolute top-0 right-0 w-1/2 h-full bg-indigo-500/5 blur-[120px] rounded-full transform translate-x-1/4 -translate-y-1/4">
        </div>
        <div
            class="absolute bottom-0 left-0 w-1/2 h-full bg-purple-500/5 blur-[120px] rounded-full transform -translate-x-1/4 translate-y-1/4">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">
                <div class="lg:col-span-2">
                    <!-- Badges -->
                    <div class="flex items-center gap-3 mb-8">
                        <span
                            class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 shadow-sm">
                            {{ $course->type }}
                        </span>
                        @if($course->level)
                            <span
                                class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 shadow-sm">
                                Level {{ $course->level }}
                            </span>
                        @endif
                        <span
                            class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800 shadow-sm">
                            Best Seller
                        </span>
                    </div>

                    <h1
                        class="text-5xl md:text-6xl font-black text-gray-900 dark:text-white mb-8 leading-[1.15] tracking-tight">
                        {{ $course->title }}
                    </h1>

                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-12 leading-relaxed max-w-2xl font-medium">
                        {{ $course->description }}
                    </p>

                    <!-- Course Stats -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 mb-12">
                        <div
                            class="p-6 rounded-2xl bg-white dark:bg-gray-800/50 shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-indigo-500 transition-colors">
                            <div
                                class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center mb-4 text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalLessonsCount }}
                            </div>
                            <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Lessons</div>
                        </div>
                        <div
                            class="p-6 rounded-2xl bg-white dark:bg-gray-800/50 shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-purple-500 transition-colors">
                            <div
                                class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center mb-4 text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="text-2xl font-black text-gray-900 dark:text-white">{{ $course->tests->count() }}
                            </div>
                            <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Quizzes</div>
                        </div>
                        <div
                            class="p-6 rounded-2xl bg-white dark:bg-gray-800/50 shadow-sm border border-gray-100 dark:border-gray-700 group hover:border-emerald-500 transition-colors col-span-2 sm:col-span-1">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center mb-4 text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div class="text-2xl font-black text-gray-900 dark:text-white">Yes</div>
                            <div class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Certificate</div>
                        </div>
                    </div>

                    <!-- Instructor -->
                    <div
                        class="flex items-center gap-6 p-6 bg-white dark:bg-gray-800/80 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-200/50 dark:shadow-none">
                        <div class="relative">
                            <div
                                class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-2xl font-black text-white shadow-lg shadow-indigo-200 dark:shadow-none">
                                {{ strtoupper(substr($course->tutor->name, 0, 1)) }}
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-4 border-white dark:border-gray-800 rounded-full">
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-black uppercase tracking-widest mb-1">Expert Instructor
                            </p>
                            <p class="text-xl font-black text-gray-900 dark:text-white">{{ $course->tutor->name }}</p>
                            <p class="text-sm text-indigo-600 dark:text-indigo-400 font-bold">12+ Courses • 5,000+
                                Students</p>
                        </div>
                    </div>
                </div>

                <!-- Enrollment Card -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl shadow-indigo-100 dark:shadow-none border-4 border-white dark:border-gray-700 overflow-hidden sticky top-24 transition-transform hover:-translate-y-2 duration-500">
                        <!-- Course Media -->
                        <div class="aspect-video bg-gray-900 relative group overflow-hidden">
                            @if($course->preview_video)
                                @php
                                    $videoUrl = $course->preview_video;
                                    $embedUrl = '';
                                    if (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
                                        $embedUrl = str_replace(['watch?v=', 'youtu.be/'], ['embed/', 'www.youtube.com/embed/'], $videoUrl);
                                        if (str_contains($embedUrl, '&')) {
                                            $embedUrl = explode('&', $embedUrl)[0];
                                        }
                                    } elseif (str_contains($videoUrl, 'vimeo.com')) {
                                        $embedUrl = str_replace('vimeo.com/', 'player.vimeo.com/video/', $videoUrl);
                                    }
                                @endphp

                                @if($embedUrl)
                                    <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                @else
                                    <video src="{{ asset('storage/' . $videoUrl) }}" controls class="w-full h-full"></video>
                                @endif
                            @elseif($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-indigo-900/40 group-hover:bg-indigo-900/60 transition-colors flex items-center justify-center">
                                    <div
                                        class="w-20 h-20 bg-white/20 backdrop-blur-xl rounded-full flex items-center justify-center text-white border border-white/30 animate-pulse">
                                        <svg class="w-10 h-10 fill-current ml-1" viewBox="0 0 20 20">
                                            <path
                                                d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.333-5.89a1.5 1.5 0 000-2.538L6.3 2.841z" />
                                        </svg>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600">
                                    <svg class="w-24 h-24 text-white opacity-40" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-10">
                            <div class="mb-8">
                                <div class="flex items-baseline gap-2 mb-2">
                                    @if($course->price > 0)
                                    <span
                                        class="text-5xl font-black text-gray-900 dark:text-white">${{ number_format((float)$course->price, 2) }}</span>
                                    @if($course->original_price > $course->price)
                                        <span
                                            class="text-xl text-gray-400 line-through font-bold">${{ number_format((float)$course->original_price, 2) }}</span>
                                    @endif
                                @else
                                        <span
                                            class="text-5xl font-black text-emerald-600 dark:text-emerald-400 uppercase">Free</span>
                                    @endif
                                </div>
                                <div
                                    class="flex items-center gap-2 text-sm font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                                    </svg>
                                    Limited Time Offer
                                </div>
                            </div>

                            @guest
                                <a href="{{ route('register') }}"
                                    class="block w-full py-5 px-6 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-center font-black text-lg shadow-xl shadow-indigo-200 dark:shadow-none transition-all hover:scale-[1.02] active:scale-[0.98] mb-4 shine">
                                    Get Started Now
                                </a>
                            @else
                                @if($course->isEnrolledBy(auth()->user()))
                                    <a href="{{ route('enrollments.show', $course) }}"
                                        class="block w-full py-5 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-center font-black text-lg shadow-xl shadow-emerald-200 dark:shadow-none transition-all hover:scale-[1.02] mb-4">
                                        Continue Learning →
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full py-5 px-6 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-center font-black text-lg shadow-xl shadow-indigo-200 dark:shadow-none transition-all hover:scale-[1.02] active:scale-[0.98] mb-4 shine">
                                            Enroll in Course
                                        </button>
                                    </form>
                                @endif
                            @endguest

                            <div class="space-y-4 pt-8">
                                <p class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Course
                                    includes:</p>
                                <div class="flex items-center gap-3 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    <div
                                        class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    Full Lifetime Access
                                </div>
                                <div class="flex items-center gap-3 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    <div
                                        class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    {{ $totalLessonsCount }} Video Lessons
                                </div>
                                <div class="flex items-center gap-3 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    <div
                                        class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    Mobile & Desktop Friendly
                                </div>
                                <div class="flex items-center gap-3 text-sm font-bold text-gray-700 dark:text-gray-300">
                                    <div
                                        class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    Official Certificate
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    </section>

    <!-- Course Content -->
    <section class="py-24 bg-white dark:bg-gray-800/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl">
                <h2 class="text-4xl font-black text-gray-900 dark:text-white mb-4">Course Curriculum</h2>
                <p class="text-lg text-gray-500 font-medium mb-12 uppercase tracking-widest">{{ $totalLessonsCount }} Lessons • {{ $course->sections->count() }} Modules</p>

                @if($course->sections->isEmpty() && $course->lessons->isEmpty())
                    <div class="text-center py-20 bg-gray-50 dark:bg-gray-800/50 rounded-[3rem] border-4 border-dashed border-gray-100 dark:border-gray-700">
                        <svg class="w-20 h-20 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <p class="text-xl font-black text-gray-400">Exciting content coming soon!</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($course->sections as $section)
                            <div class="group bg-white dark:bg-gray-800 rounded-[2rem] border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-xl hover:border-indigo-200 dark:hover:border-indigo-900">
                                <div class="px-8 py-6 flex items-center justify-between cursor-pointer">
                                    <div class="flex items-center gap-6">
                                        <div class="w-12 h-12 rounded-2xl premium-gradient flex items-center justify-center text-white font-black shadow-lg shadow-indigo-100 dark:shadow-none">
                                            {{ $loop->iteration }}
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-black text-gray-900 dark:text-white mb-1">{{ $section->title }}</h3>
                                            <div class="flex items-center gap-4">
                                                <span class="text-xs font-black text-indigo-500 uppercase tracking-widest">{{ $section->lessons->count() }} Lessons</span>
                                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                <span class="text-xs font-black text-purple-500 uppercase tracking-widest">{{ $section->tests->count() }} Quizzes</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-900/40 group-hover:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>

                                <div class="divide-y divide-gray-50 dark:divide-gray-700/50">
                                    @foreach($section->lessons as $lesson)
                                        <div class="flex items-center justify-between p-6 hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition group/item">
                                            <div class="flex items-center gap-5">
                                                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center group-hover/item:bg-white dark:group-hover/item:bg-gray-600 shadow-sm transition-colors">
                                                    @if($lesson->is_preview)
                                                        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-gray-900 dark:text-gray-100 group-hover/item:text-indigo-600 transition-colors">{{ $lesson->title }}</h4>
                                                    <span class="text-xs font-bold text-gray-400">{{ $lesson->duration_minutes ?? '15' }} mins</span>
                                                </div>
                                            </div>

                                            @if($lesson->is_preview)
                                                <span class="px-4 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-[10px] font-black rounded-full border border-emerald-200 dark:border-emerald-800 tracking-widest uppercase">Free Preview</span>
                                            @else
                                                <div class="flex items-center gap-2 text-gray-300 font-bold text-[10px] tracking-widest uppercase">
                                                    Locked
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach

                                    @foreach($section->tests as $test)
                                        <div class="flex items-center justify-between p-6 bg-amber-50/30 dark:bg-amber-900/10 group/item">
                                            <div class="flex items-center gap-5">
                                                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center text-amber-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-black text-gray-900 dark:text-gray-100">{{ $test->title }}</h4>
                                                    <span class="text-[10px] text-amber-600 dark:text-amber-500 font-black uppercase tracking-widest">Section Challenge</span>
                                                </div>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        @if($course->lessons->isNotEmpty())
                            <div class="pt-12">
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                                    Other Lessons
                                    <span class="h-px flex-1 bg-gray-100 dark:bg-gray-700"></span>
                                </h3>
                                <div class="bg-white dark:bg-gray-800 rounded-[2rem] border border-gray-100 dark:border-gray-700 divide-y divide-gray-50 dark:divide-gray-700/50 shadow-sm">
                                    @foreach($course->lessons as $lesson)
                                        <div class="flex items-center justify-between p-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition first:rounded-t-[2rem] last:rounded-b-[2rem]">
                                            <div class="flex items-center gap-5">
                                                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                    @if($lesson->is_preview)
                                                        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                                    @endif
                                                </div>
                                                <h4 class="font-black text-gray-900 dark:text-white">{{ $lesson->title }}</h4>
                                            </div>
                                            @if($lesson->is_preview)
                                                <span class="px-4 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-[10px] font-black rounded-full tracking-widest uppercase">Free</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>

                <!-- Course Tests (Orphaned) -->
                @if($course->tests->isNotEmpty())
                    <div class="mt-12">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Final Assessments
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($course->tests as $test)
                                <div
                                    class="border border-gray-100 dark:border-gray-700 p-5 rounded-2xl bg-gray-50/50 dark:bg-gray-800/50 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center shadow-sm">
                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-white">{{ $test->title }}</h4>
                                            <p class="text-xs text-gray-500 font-bold uppercase">{{ $test->questions->count() }}
                                                Questions</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative py-32 overflow-hidden">
        <div class="absolute inset-0 premium-gradient"></div>
        <!-- Animated Shapes -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 animate-float"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-black/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2 animate-float" style="animation-delay: 2s"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
            <h2 class="text-5xl md:text-6xl font-black text-white mb-8 tracking-tight">Ready to Transform Your English?</h2>
            <p class="text-2xl text-white/80 mb-12 font-medium">
                {{ $previewLessonsCount > 0 ? "Join thousands of students and start with {$previewLessonsCount} free lessons!" : "Enroll today and get instant lifetime access to all course materials." }}
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                @guest
                    <a href="{{ route('register') }}" class="px-12 py-5 bg-white text-indigo-600 font-black text-xl rounded-2xl shadow-2xl hover:bg-gray-50 transition-all hover:scale-105 active:scale-95 shine">
                        Create Free Account
                    </a>
                @else
                    @if(!$course->isEnrolledBy(auth()->user()))
                        <form method="POST" action="{{ route('courses.enroll', $course) }}">
                            @csrf
                            <button type="submit" class="px-12 py-5 bg-white text-indigo-600 font-black text-xl rounded-2xl shadow-2xl hover:bg-gray-50 transition-all hover:scale-105 active:scale-95 shine">
                                Enroll in Course Now
                            </button>
                        </form>
                    @else
                        <a href="{{ route('enrollments.show', $course) }}" class="px-12 py-5 bg-white text-emerald-600 font-black text-xl rounded-2xl shadow-2xl hover:bg-gray-50 transition-all hover:scale-105 active:scale-95">
                            Continue Your Journey
                        </a>
                    @endif
                @endauth
            </div>
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