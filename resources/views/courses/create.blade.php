<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create New Course</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Start by filling in the basic details. You can add lessons and more settings later.</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('courses.store') }}" class="p-8 space-y-6">
                    @csrf

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g., Advanced Business English"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description with AI -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description <span class="text-red-500">*</span></label>
                            <button type="button" id="generate-desc-btn" class="text-xs text-indigo-600 hover:text-indigo-500 font-medium flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Generate with AI
                            </button>
                        </div>
                        <textarea name="description" id="description" rows="6" required placeholder="What is this course about?"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Target Audience <span class="text-red-500">*</span></label>
                            <select name="type" id="type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                <option value="">Select Audience</option>
                                <option value="adult" {{ old('type') == 'adult' ? 'selected' : '' }}>Adults</option>
                                <option value="kid" {{ old('type') == 'kid' ? 'selected' : '' }}>Kids</option>
                                <option value="researcher" {{ old('type') == 'researcher' ? 'selected' : '' }}>Researchers</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price ($) <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-600 dark:text-white" placeholder="0.00">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Set to 0 for free courses.</p>
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('courses.index') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('generate-desc-btn').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            if (!title) { alert('Please enter a title first.'); return; }
            
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Generating...';
            btn.disabled = true;

            fetch('{{ route("ai.generate") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ prompt: `Write a short, engaging course description for a course titled "${title}".`, provider: 'gemini' })
            })
            .then(r => r.json())
            .then(data => {
                if (data.content) document.getElementById('description').value = data.content;
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    </script>
</x-app-layout>
