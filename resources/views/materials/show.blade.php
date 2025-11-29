<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $material->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('materials.edit', $material) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Edit
                </a>
                <form method="POST" action="{{ route('materials.destroy', $material) }}" onsubmit="return confirm('Are you sure?')">
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mb-2"><strong>Lesson:</strong> <a href="{{ route('lessons.show', $material->lesson) }}" class="text-indigo-600 hover:text-indigo-800">{{ $material->lesson->title }}</a></p>
                    <p class="mb-2"><strong>Type:</strong> {{ ucfirst($material->type) }}</p>
                    
                    <div class="mt-6">
                        @if($material->type === 'video')
                            <h3 class="text-lg font-bold mb-2">Video</h3>
                            <div class="aspect-video bg-gray-900 rounded-lg overflow-hidden">
                                <video controls class="w-full h-full">
                                    <source src="{{ $material->content }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @elseif($material->type === 'audio')
                            <h3 class="text-lg font-bold mb-2">Audio</h3>
                            <audio controls class="w-full">
                                <source src="{{ $material->content }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        @else
                            <h3 class="text-lg font-bold mb-2">Content</h3>
                            <div class="prose dark:prose-invert max-w-none">
                                {!! nl2br(e($material->content)) !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
