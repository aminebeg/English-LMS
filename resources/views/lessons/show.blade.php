<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $lesson->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('lessons.edit', $lesson) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Edit
                </a>
                <form method="POST" action="{{ route('lessons.destroy', $lesson) }}" onsubmit="return confirm('Are you sure?')">
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mb-2"><strong>Course:</strong> <a href="{{ route('courses.show', $lesson->course) }}" class="text-indigo-600 hover:text-indigo-800">{{ $lesson->course->title }}</a></p>
                    <p class="mb-2"><strong>Order:</strong> {{ $lesson->order }}</p>
                    <p class="mb-2"><strong>Free Preview:</strong> {{ $lesson->is_free ? 'Yes' : 'No' }}</p>
                </div>
            </div>

            <!-- Materials -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Materials</h3>
                        <a href="{{ route('materials.create', ['lesson' => $lesson->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Add Material
                        </a>
                    </div>
                    @if($lesson->materials->isEmpty())
                        <p>No materials yet.</p>
                    @else
                        <ul class="space-y-2">
                            @foreach($lesson->materials as $material)
                                <li class="border-b dark:border-gray-700 pb-2">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-semibold">{{ $material->title }}</span>
                                            <span class="text-sm text-gray-500">({{ ucfirst($material->type) }})</span>
                                        </div>
                                        <a href="{{ route('materials.show', $material) }}" class="text-indigo-600 hover:text-indigo-800">View</a>
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
