<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 shadow-lg mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-3">Create New Course</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">Fill in the details below to create your course. You can add lessons and materials after creation.</p>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="p-8 space-y-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900">
                                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Basic Information</h2>
                        </div>

                        <!-- Course Title -->
                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                Course Title <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                value="{{ old('title') }}" 
                                required 
                                placeholder="e.g., Advanced Business English for Professionals"
                                class="block w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 sm:text-base dark:bg-gray-900 dark:text-white transition-all duration-200"
                            >
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description with AI Enhancement -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                                    Course Description <span class="text-red-500">*</span>
                                </label>
                                <button type="button" id="generate-desc-btn" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    AI Generate
                                </button>
                            </div>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="6" 
                                required 
                                placeholder="Describe what students will learn in this course..."
                                class="block w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 sm:text-base dark:bg-gray-900 dark:text-white transition-all duration-200"
                            >{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select 
                                        name="category" 
                                        id="category" 
                                        required
                                        class="block w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 sm:text-base dark:bg-gray-900 dark:text-white appearance-none transition-all duration-200"
                                    >
                                        <option value="">Select Category</option>
                                        <option value="Language Learning" {{ old('category') == 'Language Learning' ? 'selected' : '' }}>📚 Language Learning</option>
                                        <option value="Business & Professional" {{ old('category') == 'Business & Professional' ? 'selected' : '' }}>💼 Business & Professional</option>
                                        <option value="Academic & Research" {{ old('category') == 'Academic & Research' ? 'selected' : '' }}>🎓 Academic & Research</option>
                                        <option value="Technology & Programming" {{ old('category') == 'Technology & Programming' ? 'selected' : '' }}>💻 Technology & Programming</option>
                                        <option value="Arts & Creative" {{ old('category') == 'Arts & Creative' ? 'selected' : '' }}>🎨 Arts & Creative</option>
                                        <option value="Science & Math" {{ old('category') == 'Science & Math' ? 'selected' : '' }}>🔬 Science & Math</option>
                                        <option value="Test Preparation" {{ old('category') == 'Test Preparation' ? 'selected' : '' }}>✍️ Test Preparation</option>
                                        <option value="Personal Development" {{ old('category') == 'Personal Development' ? 'selected' : '' }}>🌟 Personal Development</option>
                                        <option value="Health & Wellness" {{ old('category') == 'Health & Wellness' ? 'selected' : '' }}>🏥 Health & Wellness</option>
                                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>📌 Other</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>

                            <!-- Target Audience -->
                            <div>
                                <label for="type" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    Target Audience <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select 
                                        name="type" 
                                        id="type" 
                                        required
                                        class="block w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 sm:text-base dark:bg-gray-900 dark:text-white appearance-none transition-all duration-200"
                                    >
                                        <option value="">Select Audience</option>
                                        <option value="adult" {{ old('type') == 'adult' ? 'selected' : '' }}>👨‍💼 Adults</option>
                                        <option value="kid" {{ old('type') == 'kid' ? 'selected' : '' }}>👦 Kids</option>
                                        <option value="researcher" {{ old('type') == 'researcher' ? 'selected' : '' }}>🔬 Researchers</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Difficulty Level -->
                            <div>
                                <label for="level" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    Difficulty Level
                                </label>
                                <div class="relative">
                                    <select 
                                        name="level" 
                                        id="level"
                                        class="block w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 sm:text-base dark:bg-gray-900 dark:text-white appearance-none transition-all duration-200"
                                    >
                                        <option value="">Select Level (Optional)</option>
                                        <optgroup label="CEFR (Language)">
                                            <option value="A1" {{ old('level') == 'A1' ? 'selected' : '' }}>A1 - Beginner</option>
                                            <option value="A2" {{ old('level') == 'A2' ? 'selected' : '' }}>A2 - Elementary</option>
                                            <option value="B1" {{ old('level') == 'B1' ? 'selected' : '' }}>B1 - Intermediate</option>
                                            <option value="B2" {{ old('level') == 'B2' ? 'selected' : '' }}>B2 - Upper Intermediate</option>
                                            <option value="C1" {{ old('level') == 'C1' ? 'selected' : '' }}>C1 - Advanced</option>
                                            <option value="C2" {{ old('level') == 'C2' ? 'selected' : '' }}>C2 - Proficiency</option>
                                        </optgroup>
                                        <optgroup label="General">
                                            <option value="Beginner" {{ old('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                            <option value="Intermediate" {{ old('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                            <option value="Advanced" {{ old('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                            <option value="Expert" {{ old('level') == 'Expert' ? 'selected' : '' }}>Expert</option>
                                        </optgroup>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Use CEFR levels for language courses, or general levels for other subjects</p>
                                <x-input-error :messages="$errors->get('level')" class="mt-2" />
                            </div>

                            <!-- Placeholder for future field -->
                            <div>
                                <!-- Reserved for additional field if needed -->
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Section -->
                    <div class="p-8 space-y-6 bg-gray-50 dark:bg-gray-900/50">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Pricing</h2>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                Course Price (USD) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 text-lg font-semibold">$</span>
                                </div>
                                <input 
                                    type="number" 
                                    name="price" 
                                    id="price" 
                                    value="{{ old('price', 0) }}" 
                                    min="0" 
                                    step="0.01" 
                                    required
                                    placeholder="0.00"
                                    class="block w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 shadow-sm focus:border-green-500 focus:ring-4 focus:ring-green-500/20 sm:text-base dark:bg-gray-900 dark:text-white transition-all duration-200"
                                >
                            </div>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Set to $0.00 for free courses
                            </p>
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="p-8 bg-gray-50 dark:bg-gray-800/50 flex items-center justify-between gap-4">
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-base font-semibold text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 border border-transparent shadow-lg text-base font-bold rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/50 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Create Course
                        </button>
                    </div>
                </form>
            </div>

            <!-- Help Text -->
            <div class="mt-8 p-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-blue-900 dark:text-blue-100 mb-1">What happens next?</h3>
                        <p class="text-sm text-blue-800 dark:text-blue-200">After creating your course, you'll be able to add lessons, upload materials, create tests, and publish when ready. Students can only enroll once the course is published.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('generate-desc-btn').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            if (!title) {
                alert('Please enter a course title first.');
                return;
            }
            
            const btn = this;
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Generating...';
            btn.disabled = true;

            fetch('{{ route("ai.generate") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ 
                    prompt: `Write a compelling, professional course description for an English learning course titled "${title}". Make it engaging and highlight the key benefits. Keep it to 2-3 paragraphs.`, 
                    provider: 'cerebras' 
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.content) {
                    document.getElementById('description').value = data.content;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to generate description. Please try again.');
            })
            .finally(() => {
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            });
        });
    </script>
</x-app-layout>
