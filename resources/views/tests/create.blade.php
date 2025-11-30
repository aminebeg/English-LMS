<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Course
                </a>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                    Create New Test
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Add an assessment to <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $course->title }}</span></p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
                <!-- Gradient Top Border -->
                <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <form method="POST" action="{{ route('tests.store') }}" class="p-8">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Test Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required 
                            class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-lg"
                            placeholder="e.g., Unit 1 Quiz">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Passing Score -->
                        <div>
                            <label for="passing_score" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Passing Score (%) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="passing_score" name="passing_score" value="{{ old('passing_score', 70) }}" min="0" max="100" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm pr-12">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500">%</span>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('passing_score')" class="mt-2" />
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Order <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="order" name="order" value="{{ old('order', $course->tests->count() + 1) }}" required min="1"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('courses.show', $course) }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            Cancel
                        </a>

                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-200">
                            🚀 Create Test
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
