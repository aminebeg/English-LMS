<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <a href="{{ route('classrooms.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Classrooms
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Create New Classroom
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Set up a virtual classroom for live sessions</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <form method="POST" action="{{ route('classrooms.store') }}" class="p-8">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Classroom Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            placeholder="e.g., Business English Live Session">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            placeholder="What will students learn in this classroom?">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- Course Association --}}
                    <div class="mb-6">
                        <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Associate with Course (Optional)
                        </label>
                        <select id="course_id" name="course_id"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="">None (Independent Classroom)</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Link this classroom to a specific course for live sessions</p>
                        <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Max Participants --}}
                        <div>
                            <label for="max_participants" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Max Participants <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="max_participants" name="max_participants" value="{{ old('max_participants', 50) }}" required min="2" max="500"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <x-input-error :messages="$errors->get('max_participants')" class="mt-2" />
                        </div>

                        {{-- Duration --}}
                        <div>
                            <label for="duration_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Duration (minutes)
                            </label>
                            <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', 60) }}" min="15" max="480"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Schedule --}}
                    <div class="mb-6">
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Schedule For (Optional)
                        </label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty for anytime access</p>
                        <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                    </div>

                    {{-- Price (for standalone classrooms) --}}
                    <div class="mb-6">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Price (USD)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" id="price" name="price" value="{{ old('price', 0) }}" min="0" step="0.01"
                                class="w-full pl-7 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="0.00">
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Set to 0 for free access. Pricing applies to standalone classrooms only.</p>
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    {{-- Public/Private & Featured --}}
                    <div class="mb-8 space-y-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_public" name="is_public" type="checkbox" value="1" {{ old('is_public', true) ? 'checked' : '' }}
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3">
                                <label for="is_public" class="font-medium text-gray-700 dark:text-gray-300">Public Classroom</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Allow anyone to discover and join this classroom</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3">
                                <label for="is_featured" class="font-medium text-gray-700 dark:text-gray-300">Featured Classroom</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Display this classroom on the homepage (standalone classrooms only)</p>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('classrooms.index') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors shadow-sm">
                            Create Classroom
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
