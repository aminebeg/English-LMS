<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Create New Course</h1>
                <p class="text-gray-600 dark:text-gray-400">Share your knowledge with the world</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Gradient Top Border -->
                <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <div class="p-8">
                    <form method="POST" action="{{ route('courses.store') }}" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Course Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required 
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm"
                                placeholder="e.g., Advanced English Grammar Mastery">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description with AI -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <button type="button" id="generate-description" 
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Generate with AI
                                </button>
                            </div>
                            <textarea id="description" name="description" rows="5" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm"
                                placeholder="Describe what students will learn...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Audience</label>
                                <select id="type" name="type" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
                                    <option value="adult">Adults</option>
                                    <option value="kid">Kids</option>
                                    <option value="researcher">Researchers/Academic</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Level -->
                            <div>
                                <label for="level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Difficulty Level</label>
                                <select id="level" name="level"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
                                    <option value="">No specific level</option>
                                    <option value="A1">A1 - Beginner</option>
                                    <option value="A2">A2 - Elementary</option>
                                    <option value="B1">B1 - Intermediate</option>
                                    <option value="B2">B2 - Upper Intermediate</option>
                                    <option value="C1">C1 - Advanced</option>
                                    <option value="C2">C2 - Proficiency</option>
                                </select>
                                <x-input-error :messages="$errors->get('level')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price ($)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" id="price" name="price" value="{{ old('price', 0) }}" step="0.01" min="0" required
                                    class="w-full pl-7 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Set to 0 for free courses</p>
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('courses.index') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200">
                                Create Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('generate-description').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            const type = document.getElementById('type').value;
            const level = document.getElementById('level').value;
            
            if (!title) {
                alert('Please enter a course title first.');
                return;
            }

            const prompt = `Write a compelling course description for an English course titled "${title}". Type: ${type}. Level: ${level}. Keep it under 200 words.`;
            const button = this;
            const originalContent = button.innerHTML;
            button.innerHTML = '<svg class="animate-spin w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
            button.disabled = true;

            fetch('{{ route('ai.generate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ prompt: prompt, provider: 'gemini' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.content) {
                    document.getElementById('description').value = data.content;
                } else {
                    alert('Error generating content: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            })
            .finally(() => {
                button.innerHTML = originalContent;
                button.disabled = false;
            });
        });
    </script>
</x-app-layout>
