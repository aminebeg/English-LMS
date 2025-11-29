<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $course->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('courses.edit', $course) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Edit
                </a>
                <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Course Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Course Details</h3>
                    <p class="mb-2"><strong>Description:</strong> {{ $course->description }}</p>
                    <p class="mb-2"><strong>Type:</strong> {{ ucfirst($course->type) }}</p>
                    <p class="mb-2"><strong>Level:</strong> {{ $course->level ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Price:</strong> ${{ $course->price }}</p>
                    <p class="mb-2"><strong>Status:</strong> {{ $course->is_published ? 'Published' : 'Draft' }}</p>
                </div>
            </div>

            <!-- Lessons -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Lessons</h3>
                        <a href="{{ route('lessons.create', ['course' => $course->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Add Lesson
                        </a>
                    </div>
                    @if($course->lessons->isEmpty())
                        <p>No lessons yet.</p>
                    @else
                        <ul class="space-y-2">
                            @foreach($course->lessons as $lesson)
                                <li class="border-b dark:border-gray-700 pb-2">
                                    <div class="flex justify-between items-center">
                                        <span>{{ $lesson->order }}. {{ $lesson->title }}</span>
                                        <a href="{{ route('lessons.show', $lesson) }}" class="text-indigo-600 hover:text-indigo-800">View</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Tests -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Tests</h3>
                        <a href="{{ route('tests.create', ['course' => $course->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Add Test
                        </a>
                    </div>
                    @if($course->tests->isEmpty())
                        <p>No tests yet.</p>
                    @else
                        <ul class="space-y-2">
                            @foreach($course->tests as $test)
                                <li class="border-b dark:border-gray-700 pb-2">
                                    <div class="flex justify-between items-center">
                                        <span>{{ $test->title }} (Passing: {{ $test->passing_score }}%)</span>
                                        <a href="{{ route('tests.show', $test) }}" class="text-indigo-600 hover:text-indigo-800">View</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
