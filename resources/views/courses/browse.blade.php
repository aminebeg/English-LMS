<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Browse Courses') }}
            </h2>
            
            <form method="GET" action="{{ route('courses.browse') }}" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses..." 
                        class="w-full sm:w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                
                <select name="level" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">All Levels</option>
                    <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
                
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">
                    Search
                </button>
                
                @if(request('search') || request('level'))
                    <a href="{{ route('courses.browse') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($courses->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>No courses available at the moment. Check back later!</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($courses as $course)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                            <div class="p-6">
                                <!-- Course Title -->
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $course->title }}
                                </h3>

                                <!-- Course Type & Level Badge -->
                                <div class="flex gap-2 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ ucfirst($course->type) }}
                                    </span>
                                    @if($course->level)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            {{ $course->level }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                                    {{ $course->description }}
                                </p>

                                <!-- Course Stats -->
                                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <span>📚 {{ $course->lessons->count() }} Lessons</span>
                                    <span>📝 {{ $course->tests->count() }} Tests</span>
                                </div>

                                <!-- Tutor Info -->
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    <strong>Tutor:</strong> {{ $course->tutor->name }}
                                </p>

                                <!-- Price & Enroll Button -->
                                <div class="flex items-center justify-between pt-4 border-t dark:border-gray-700">
                                    <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        @if($course->price > 0)
                                            ${{ number_format($course->price, 2) }}
                                        @else
                                            <span class="text-green-600 dark:text-green-400">Free</span>
                                        @endif
                                    </span>

                                    @if($course->isEnrolledBy(auth()->user()))
                                        <a href="{{ route('enrollments.show', $course) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                            Continue Learning
                                        </a>
                                    @else
                                        <form method="POST" action="{{ route('courses.enroll', $course) }}">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                                Enroll Now
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
