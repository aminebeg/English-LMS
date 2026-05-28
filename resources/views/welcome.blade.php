<?php
// English Space Landing Page Configuration
// Easily customize all the text on the landing page here.

$config = [
    'app_name' => 'English Space',
    'hero' => [
        'badge' => 'Join our active learners',
        'title_prefix' => 'Master English with',
        'title_highlight' => 'Expert Tutors',
        'description' => 'Transform your English skills with personalized courses and interactive learning experiences.',
        'primary_cta' => 'Start Learning Free',
        'secondary_cta' => 'Explore Courses',
    ],
    'features_header' => [
        'badge' => 'WHY CHOOSE US',
        'title' => 'Everything You Need to Succeed',
        'description' => 'The most comprehensive platform for learning English online.',
    ],
    'features' => [
        [
            'title' => 'Expert Tutors',
            'description' => 'Learn from certified English teachers with years of experience and proven teaching methods.',
            'icon' => '<svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',
            'span' => 'col-span-1 md:col-span-2 lg:col-span-2',
        ],
        [
            'title' => 'Interactive Learning',
            'description' => 'Engage with dynamic lessons, quizzes, and multimedia content to master English effectively.',
            'icon' => '<svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>',
            'span' => 'col-span-1 lg:col-span-1',
        ],
        [
            'title' => 'Get Certified',
            'description' => 'Earn certificates upon course completion to showcase your skills and boost your career.',
            'icon' => '<svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>',
            'span' => 'col-span-1 lg:col-span-1',
        ],
        [
            'title' => 'Learn Anywhere',
            'description' => 'Access your courses from any device. Our platform is fully responsive and mobile-friendly.',
            'icon' => '<svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>',
            'span' => 'col-span-1 md:col-span-2 lg:col-span-2',
        ],
    ],
    'courses_header' => [
        'badge' => 'FEATURED COURSES',
        'title' => 'Start Your Learning Journey',
        'description' => 'Choose from our most popular courses designed by expert tutors.',
    ],
    'cta_section' => [
        'title' => 'Ready to Start Your Journey?',
        'description' => 'Join thousands of students improving their English skills every day.',
        'primary_btn' => 'Create Free Account',
        'secondary_btn' => 'Teach on English Space',
    ],
    'footer' => [
        'description' => 'Your premier online destination for mastering the English language with expert tutors and interactive learning.',
        'links' => [
            ['label' => 'About Us', 'url' => '#'],
            ['label' => 'Contact Support', 'url' => '#'],
            ['label' => 'Privacy Policy', 'url' => '#'],
            ['label' => 'Terms of Service', 'url' => '#'],
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $config['app_name'] }} - Master English</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb; /* gray-50 */
            color: #111827; /* gray-900 */
            overflow-x: hidden;
        }

        /* Glassmorphism Navigation */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .bento-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        
        .bento-card:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .text-gradient {
            background: linear-gradient(135deg, #4f46e5, #ec4899, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }

        .bg-gradient-mesh {
            background-color: #f9fafb;
            background-image: 
                radial-gradient(at 40% 20%, rgba(79, 70, 229, 0.15) 0px, transparent 50%),
                radial-gradient(at 80% 0%, rgba(236, 72, 153, 0.15) 0px, transparent 50%),
                radial-gradient(at 0% 50%, rgba(139, 92, 246, 0.15) 0px, transparent 50%);
        }

        /* Animations */
        @keyframes float-smooth {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .animate-float-smooth {
            animation: float-smooth 6s ease-in-out infinite;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="antialiased min-h-screen bg-gradient-mesh">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full glass-nav z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-[2px] shadow-lg shadow-indigo-500/20 group-hover:shadow-indigo-500/40 transition-all duration-300">
                        <div class="w-full h-full bg-white rounded-[10px] flex items-center justify-center relative overflow-hidden">
                            <svg class="w-6 h-6 text-indigo-600 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="text-2xl font-bold tracking-tight text-gray-900">{{ $config['app_name'] }}</span>
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-gray-600 hover:text-indigo-600 font-medium transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-gray-600 hover:text-indigo-600 font-medium transition-colors">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gray-900 text-white font-semibold rounded-lg hover:bg-gray-800 transform hover:-translate-y-0.5 transition-all duration-200 shadow-md">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden flex items-center min-h-[85vh]">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
            <div class="text-center max-w-4xl mx-auto flex flex-col items-center">
                
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-indigo-200 bg-indigo-50/50 backdrop-blur-md mb-8 animate-float-smooth">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="text-sm font-semibold text-indigo-700">{{ $config['hero']['badge'] }}</span>
                </div>

                <!-- Headline -->
                <h1 class="text-5xl md:text-7xl font-black mb-6 leading-[1.15] tracking-tight text-gray-900">
                    {{ $config['hero']['title_prefix'] }} <br/>
                    <span class="text-gradient">
                        {{ $config['hero']['title_highlight'] }}
                    </span>
                </h1>

                <!-- Description -->
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed font-medium">
                    {{ $config['hero']['description'] }}
                </p>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center w-full sm:w-auto">
                    @guest
                        <a href="{{ route('register') }}" class="group relative px-8 py-4 bg-gray-900 text-white font-bold rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300">
                            <span class="relative flex items-center justify-center gap-2 text-lg">
                                {{ $config['hero']['primary_cta'] }}
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            </span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="group relative px-8 py-4 bg-gray-900 text-white font-bold rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300">
                            <span class="relative flex items-center justify-center gap-2 text-lg">
                                Dashboard
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            </span>
                        </a>
                    @endguest

                    <a href="#courses" class="px-8 py-4 bg-white text-gray-900 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-300 text-lg border border-gray-200 shadow-sm">
                        {{ $config['hero']['secondary_cta'] }}
                    </a>
                </div>

                <!-- Stats Footer -->
                <div class="mt-16 pt-8 flex flex-wrap justify-center gap-8 md:gap-16">
                    <div class="text-center">
                        <div class="text-3xl font-black text-gray-900 mb-1">{{ \App\Models\Course::published()->count() }}+</div>
                        <div class="text-sm text-gray-500 font-semibold">Active Courses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-gray-900 mb-1">{{ \App\Models\User::role('tutor')->count() }}+</div>
                        <div class="text-sm text-gray-500 font-semibold">Expert Tutors</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-gray-900 mb-1">{{ \App\Models\User::role('student')->count() }}+</div>
                        <div class="text-sm text-gray-500 font-semibold">Happy Students</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Bento Box Features Section -->
    <section class="py-24 relative z-10 bg-white border-y border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16 text-center max-w-3xl mx-auto">
                <span class="text-indigo-600 font-bold tracking-wider text-sm uppercase mb-3 block">
                    {{ $config['features_header']['badge'] }}
                </span>
                <h2 class="text-4xl md:text-5xl font-black mb-4 text-gray-900 tracking-tight">
                    {{ $config['features_header']['title'] }}
                </h2>
                <p class="text-xl text-gray-500">
                    {{ $config['features_header']['description'] }}
                </p>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-[250px]">
                @foreach ($config['features'] as $feature)
                <div class="bento-card rounded-3xl p-8 flex flex-col justify-between group {{ $feature['span'] }} relative overflow-hidden">
                    <div class="mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center mb-6 shadow-sm">
                            {!! $feature['icon'] !!}
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">{{ $feature['title'] }}</h3>
                        <p class="text-gray-500 font-medium">{{ $feature['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Courses Section -->
    @php
        $featuredCourses = \App\Models\Course::published()
            ->with(['tutor', 'lessons', 'tests'])
            ->latest()
            ->take(6)
            ->get();
    @endphp
    <section id="courses" class="py-24 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <span class="text-pink-500 font-bold tracking-wider text-sm uppercase mb-3 block">
                        {{ $config['courses_header']['badge'] }}
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight">
                        {{ $config['courses_header']['title'] }}
                    </h2>
                </div>
                <div>
                    <a href="{{ route('courses.browse') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 shadow-sm rounded-xl hover:bg-gray-50 transition-colors text-gray-900 font-semibold">
                        Browse All Courses <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>

            @if ($featuredCourses->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300 shadow-sm">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-50 rounded-2xl flex items-center justify-center border border-gray-100">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">Amazing Courses Coming Soon!</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Our expert tutors are preparing incredible courses for you.</p>
                    @auth
                        @if (auth()->user()->hasRole('tutor'))
                            <a href="{{ route('courses.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                                Create First Course
                            </a>
                        @endif
                    @endauth
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($featuredCourses as $course)
                        <div class="group bg-white rounded-2xl overflow-hidden flex flex-col h-full border border-gray-100 hover-lift relative shadow-sm">
                            <!-- Image Header -->
                            <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
                                @if ($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-24 h-24 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Badges -->
                                <div class="absolute top-4 left-4 z-20 flex gap-2">
                                    <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-indigo-700 text-xs font-bold rounded-full uppercase tracking-wider shadow-sm">
                                        {{ $course->type }}
                                    </span>
                                    @if ($course->level)
                                        <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider shadow-sm">
                                            {{ $course->level }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Body -->
                            <div class="p-6 flex-1 flex flex-col relative">
                                <!-- Price Floating Bubble -->
                                <div class="absolute -top-6 right-6 z-20">
                                    @if ($course->price > 0)
                                        <div class="flex items-center justify-center px-4 py-2 bg-white text-gray-900 font-bold rounded-xl shadow-lg border border-gray-100">
                                            ${{ number_format($course->price, 2) }}
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center px-4 py-2 bg-gradient-to-r from-emerald-400 to-emerald-500 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30">
                                            FREE
                                        </div>
                                    @endif
                                </div>

                                <h3 class="text-xl font-bold mb-3 text-gray-900 line-clamp-2 mt-2 group-hover:text-indigo-600 transition-colors">
                                    {{ $course->title }}
                                </h3>
                                
                                <p class="text-gray-500 text-sm mb-6 line-clamp-2 font-medium flex-1">
                                    {{ $course->description }}
                                </p>

                                <!-- Footer Info -->
                                <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-auto">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                                            {{ strtoupper(substr($course->tutor->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">{{ $course->tutor->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 font-medium">
                                        <span class="flex items-center gap-1" title="Lessons">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                            {{ $course->lessons->count() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden Link Overlay -->
                            <a href="{{ route('courses.preview', $course) }}" class="absolute inset-0 z-30">
                                <span class="sr-only">View Details for {{ $course->title }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Bottom CTA -->
    <section class="py-24 relative overflow-hidden z-10 bg-indigo-600">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 left-10 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-float-smooth"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-float-smooth" style="animation-delay: 2s;"></div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">
                {{ $config['cta_section']['title'] }}
            </h2>
            <p class="text-xl mb-10 text-indigo-100 font-medium">
                {{ $config['cta_section']['description'] }}
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 text-lg">
                        {{ $config['cta_section']['primary_btn'] }}
                    </a>
                    <a href="{{ route('tutor.register.form') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white hover:text-indigo-600 transition-all text-lg">
                        {{ $config['cta_section']['secondary_btn'] }}
                    </a>
                @else
                    <a href="{{ route('courses.browse') }}" class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 text-lg">
                        Browse All Courses
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-12 border-t border-gray-200 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-pink-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-gray-900">{{ $config['app_name'] }}</span>
                </div>
                <p class="text-gray-500 mb-8 max-w-md mx-auto font-medium">
                    {{ $config['footer']['description'] }}
                </p>
                <div class="flex flex-wrap items-center justify-center gap-6 mb-8">
                    @foreach ($config['footer']['links'] as $link)
                        <a href="{{ $link['url'] }}" class="text-sm text-gray-500 hover:text-indigo-600 transition-colors font-semibold">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
                <div class="w-24 h-1 bg-gray-200 mx-auto rounded-full mb-8"></div>
                <p class="text-xs text-gray-400 font-semibold tracking-wide">
                    &copy; {{ date('Y') }} {{ $config['app_name'] }}. ALL RIGHTS RESERVED.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>