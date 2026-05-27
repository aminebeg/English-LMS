<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen grid lg:grid-cols-2">
        <!-- Branding Side (Left) - Hidden on mobile, visible on large screens -->
        <div
            class="hidden lg:flex relative bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 overflow-hidden">
            <!-- Decorative Background Elements -->
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute top-0 -left-4 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-blob">
                </div>
                <div
                    class="absolute top-0 -right-4 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-2000">
                </div>
                <div
                    class="absolute -bottom-8 left-20 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-4000">
                </div>
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                <!-- Logo & Branding -->
                <div>
                    <a href="/" class="inline-block">
                        <h1 class="text-4xl font-extrabold text-white mb-3">English LMS</h1>
                    </a>
                    <p class="text-indigo-100 text-lg font-medium">Master English with Expert Tutors</p>
                </div>

                <!-- Feature Highlights -->
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-lg mb-1">Expert-Led Courses</h3>
                            <p class="text-indigo-100 text-sm">Learn from qualified tutors with proven teaching methods
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-lg mb-1">Certified Achievement</h3>
                            <p class="text-indigo-100 text-sm">Earn certificates upon course completion</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-lg mb-1">Learn at Your Pace</h3>
                            <p class="text-indigo-100 text-sm">Flexible learning tailored to your schedule</p>
                        </div>
                    </div>
                </div>

                <!-- Footer Quote -->
                <div class="mt-8 pt-8 border-t border-white/20">
                    <p class="text-white/90 italic text-sm">"The journey of a thousand miles begins with a single step."
                    </p>
                    <p class="text-indigo-200 text-xs mt-2">Start your English learning journey today</p>
                </div>
            </div>
        </div>

        <!-- Form Side (Right) -->
        <div class="flex flex-col justify-center bg-white px-6 py-12 sm:px-12 lg:px-16 xl:px-24">
            <!-- Mobile Logo -->
            <div class="lg:hidden mb-8 text-center">
                <a href="/" class="inline-block">
                    <h1 class="text-3xl font-extrabold text-indigo-600">English LMS</h1>
                </a>
            </div>

            <!-- Form Content -->
            <div class="w-full max-w-md mx-auto">
                {{ $slot }}
            </div>
        </div>
    </div>

    <style>
        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            25% {
                transform: translate(20px, -50px) scale(1.1);
            }

            50% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            75% {
                transform: translate(20px, 50px) scale(1.05);
            }
        }

        .animate-blob {
            animation: blob 15s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>

</html>
