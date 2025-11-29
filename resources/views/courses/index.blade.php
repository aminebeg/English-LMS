<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Courses') }}
            </h2>
            <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                Create Course
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($courses->isEmpty())
                        <p>No courses yet. Create your first course!</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($courses as $course)
                                <div class="border dark:border-gray-700 rounded-lg p-4 hover:shadow-lg transition">
                                    <h3 class="text-lg font-bold mb-2">{{ $course->title }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ Str::limit($course->description, 100) }}</p>
                                    <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-500 mb-4">
                                        <span>{{ ucfirst($course->type) }}</span>
                                        <span>{{ $course->level ?? 'No level' }}</span>
                                        <span>${{ $course->price }}</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 hover:text-indigo-800">View</a>
                                        <a href="{{ route('courses.edit', $course) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
