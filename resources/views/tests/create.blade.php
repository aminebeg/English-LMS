<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Course
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create New Test</h1>
                <p class="text-gray-600 dark:text-gray-400">Add an assessment to <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $course->title }}</span></p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Gradient Top Border -->
                <div class="h-2 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500"></div>

                <div class="p-8">
                    <form method="POST" action="{{ route('tests.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Test Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required 
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm"
                                placeholder="e.g., Unit 1 Quiz">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Passing Score -->
                            <div>
                                <label for="passing_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Passing Score (%)</label>
                                <div class="relative">
                                    <input type="number" id="passing_score" name="passing_score" value="{{ old('passing_score', 70) }}" min="0" max="100" required
                                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm pr-8">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">%</span>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('passing_score')" class="mt-2" />
                            </div>

                            <!-- Order -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order</label>
                                <input type="number" id="order" name="order" value="{{ old('order', $course->tests->count() + 1) }}" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
                                <x-input-error :messages="$errors->get('order')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('courses.show', $course) }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200">
                                Create Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
