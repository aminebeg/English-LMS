<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Classroom</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update your classroom settings</p>
            </div>

            {{-- Edit Form --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <form action="{{ route('classrooms.update', $classroom) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Classroom Title *
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title', $classroom->title) }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                            placeholder="e.g., Business English Live Session"
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Describe what students will learn in this classroom..."
                        >{{ old('description', $classroom->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Course Association --}}
                    <div class="mb-6">
                        <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Associated Course (Optional)
                        </label>
                        <select 
                            id="course_id" 
                            name="course_id"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="">-- No Course --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $classroom->course_id) == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Link this classroom to a specific course</p>
                        @error('course_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Max Participants --}}
                    <div class="mb-6">
                        <label for="max_participants" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Maximum Participants *
                        </label>
                        <input 
                            type="number" 
                            id="max_participants" 
                            name="max_participants" 
                            value="{{ old('max_participants', $classroom->max_participants) }}"
                            min="2"
                            max="500"
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Between 2 and 500 participants</p>
                        @error('max_participants')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Scheduled Time --}}
                    <div class="mb-6">
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Scheduled Time (Optional)
                        </label>
                        <input 
                            type="datetime-local" 
                            id="scheduled_at" 
                            name="scheduled_at" 
                            value="{{ old('scheduled_at', $classroom->scheduled_at ? $classroom->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty for anytime access</p>
                        @error('scheduled_at')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Is Public --}}
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="is_public" 
                                value="1"
                                {{ old('is_public', $classroom->is_public) ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700"
                            >
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                Make this classroom public
                            </span>
                        </label>
                        <p class="mt-1 ml-6 text-xs text-gray-500 dark:text-gray-400">Public classrooms appear in the browse list</p>
                        @error('is_public')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div class="mb-6">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Price (USD)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input 
                                type="number" 
                                id="price" 
                                name="price" 
                                value="{{ old('price', $classroom->price) }}"
                                min="0"
                                step="0.01"
                                class="w-full pl-7 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                                placeholder="0.00"
                            >
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Set to 0 for free access</p>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Featured --}}
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="is_featured" 
                                value="1"
                                {{ old('is_featured', $classroom->is_featured) ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700"
                            >
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                Featured classroom
                            </span>
                        </label>
                        <p class="mt-1 ml-6 text-xs text-gray-500 dark:text-gray-400">Display on homepage (standalone classrooms only)</p>
                        @error('is_featured')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Join Code (Read-only) --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Join Code
                        </label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="text" 
                                value="{{ $classroom->join_code }}"
                                readonly
                                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white cursor-not-allowed"
                            >
                            <button 
                                type="button"
                                onclick="navigator.clipboard.writeText('{{ $classroom->join_code }}')"
                                class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                            >
                                Copy
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Share this code with students to join</p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a 
                            href="{{ route('classrooms.index') }}" 
                            class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors"
                        >
                            Cancel
                        </a>
                        <div class="flex items-center gap-3">
                            {{-- Delete Button --}}
                            <button 
                                type="button"
                                onclick="if(confirm('Are you sure you want to delete this classroom? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }"
                                class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors"
                            >
                                Delete
                            </button>
                            {{-- Update Button --}}
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 shadow-sm transition-colors"
                            >
                                Update Classroom
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Delete Form (Hidden) --}}
                <form id="delete-form" action="{{ route('classrooms.destroy', $classroom) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
