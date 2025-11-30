<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Course
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Add Lesson</h1>
                <p class="text-gray-600 dark:text-gray-400">Add new content to <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $course->title }}</span></p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Gradient Top Border -->
                <div class="h-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>

                <div class="p-8">
                    <form method="POST" action="{{ route('lessons.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lesson Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required 
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm"
                                placeholder="e.g., Introduction to Verb Tenses">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Content with AI -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lesson Content</label>
                                <button type="button" id="generate-content" 
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Generate with AI
                                </button>
                            </div>
                            <textarea id="content" name="content" rows="12" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm font-mono text-sm"
                                placeholder="# Lesson Header&#10;&#10;Write your lesson content here using Markdown...">{{ old('content') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Supports Markdown formatting</p>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Order -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order</label>
                                <input type="number" id="order" name="order" value="{{ old('order', $course->lessons->count() + 1) }}" required
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
                                <x-input-error :messages="$errors->get('order')" class="mt-2" />
                            </div>

                            <!-- Free Preview -->
                            <div class="flex items-center h-full pt-6">
                                <label class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-colors">
                                    <input type="checkbox" name="is_preview" value="1" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    <div class="ml-3">
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Free Preview Lesson</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">Allow guests to view this lesson</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('courses.show', $course) }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200">
                                Create Lesson
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('generate-content').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            
            if (!title) {
                alert('Please enter a lesson title first.');
                return;
            }

            const prompt = `Write a comprehensive lesson content for an English lesson titled "${title}". Use Markdown formatting with headers, bullet points, and examples. Keep it educational and engaging.`;
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
                    document.getElementById('content').value = data.content;
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
