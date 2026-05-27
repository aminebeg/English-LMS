<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('courses.show', $course) }}"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Course
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Create New Test
                </h1>
                <p class="text-gray-700">Add an assessment to <span
                        class="font-semibold text-indigo-600">{{ $course->title }}</span></p>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <form method="POST" action="{{ route('tests.store') }}" class="p-8">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Test Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            placeholder="e.g., Unit 1 Quiz">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Passing Score -->
                        <div>
                            <label for="passing_score" class="block text-sm font-medium text-gray-700 mb-2">
                                Passing Score (%) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="passing_score" name="passing_score"
                                    value="{{ old('passing_score', 70) }}" min="0" max="100" required
                                    class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm pr-12">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500">%</span>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('passing_score')" class="mt-2" />
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                                Order <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="order" name="order"
                                value="{{ old('order', $course->tests->count() + 1) }}" required min="1"
                                class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Test Type & Association -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Test Type
                            </label>
                            <select id="type" name="type"
                                class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                <option value="final_exam" {{ old('type') == 'final_exam' ? 'selected' : '' }}>Final
                                    Exam</option>
                            </select>
                        </div>

                        <!-- Section Association -->
                        <div>
                            <label for="course_section_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Associate with Section (Optional)
                            </label>
                            <select id="course_section_id" name="course_section_id"
                                class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                <option value="">None (Course Level)</option>
                                @foreach ($course->sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ (old('course_section_id') ?? request('course_section_id')) == $section->id ? 'selected' : '' }}>
                                        {{ $section->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lesson Association -->
                        <div>
                            <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Associate with Lesson (Optional)
                            </label>
                            <select id="lesson_id" name="lesson_id"
                                class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                <option value="">None</option>
                                @foreach ($course->lessons as $lesson)
                                    <option value="{{ $lesson->id }}"
                                        {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                        {{ $lesson->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('courses.show', $course) }}"
                            class="text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors">
                            Cancel
                        </a>

                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors shadow-sm">
                            Create Test
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
