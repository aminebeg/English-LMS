<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Course
                </a>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                    Create New Lesson
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Add content to <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $course->title }}</span></p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
                <!-- Gradient Top Border -->
                <div class="h-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>

                <!-- Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex px-8 pt-6" aria-label="Tabs">
                        <button type="button" class="tab-button active" data-tab="content">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Content
                        </button>
                        <button type="button" class="tab-button" data-tab="details">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Details
                        </button>
                        <button type="button" class="tab-button" data-tab="interactive">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                            </svg>
                            Interactive
                        </button>
                        <button type="button" class="tab-button" data-tab="resources">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Resources
                        </button>
                    </nav>
                </div>

                <form method="POST" action="{{ route('lessons.store') }}" id="lessonForm" class="p-8">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                    <!-- Tab 1: Content -->
                    <div class="tab-content active" data-tab="content">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Lesson Content</h2>

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Lesson Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required 
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-lg"
                                placeholder="e.g., Mastering Present Perfect Tense">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Summary -->
                        <div class="mb-6">
                            <label for="summary" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Summary
                            </label>
                            <textarea id="summary" name="summary" rows="3"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="Brief overview of what this lesson covers...">{{ old('summary') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Short description shown in lesson previews</p>
                        </div>

                        <!-- Main Content with AI -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Main Content <span class="text-red-500">*</span>
                                </label>
                                <button type="button" id="generate-content" 
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Generate with AI
                                </button>
                            </div>
                            <textarea id="content" name="content" rows="15" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm font-mono text-sm"
                                placeholder="# Introduction&#10;&#10;Write your lesson content here using **Markdown** formatting...&#10;&#10;## Key Concepts&#10;- Point 1&#10;- Point 2&#10;&#10;### Examples&#10;```&#10;Example code or text&#10;```">{{ old('content') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Supports Markdown formatting for rich content</p>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <!-- Video URL -->
                        <div class="mb-6">
                            <label for="video_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Video URL (Optional)
                            </label>
                            <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="https://youtube.com/watch?v=...">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">YouTube, Vimeo, or direct video URL</p>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Teacher's Notes
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="Additional notes, tips, or teaching instructions...">{{ old('notes') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Private notes for instructors (not visible to students)</p>
                        </div>
                    </div>

                    <!-- Tab 2: Details -->
                    <div class="tab-content" data-tab="details">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Lesson Details</h2>

                        <!-- Learning Objectives -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Learning Objectives
                            </label>
                            <div class="space-y-2 mb-2" id="objectives-list"></div>
                            <div class="flex gap-2">
                                <input type="text" id="objective-input" 
                                    class="flex-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                    placeholder="What will students learn in this lesson?">
                                <button type="button" id="add-objective-btn" class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors">
                                    Add
                                </button>
                            </div>
                            <input type="hidden" name="objectives" id="objectives-hidden" value="[]">
                        </div>

                        <!-- Key Points -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Key Points to Remember
                            </label>
                            <div class="space-y-2 mb-2" id="keypoints-list"></div>
                            <div class="flex gap-2">
                                <input type="text" id="keypoint-input" 
                                    class="flex-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                    placeholder="Important points students should remember">
                                <button type="button" id="add-keypoint-btn" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                                    Add
                                </button>
                            </div>
                            <input type="hidden" name="key_points" id="keypoints-hidden" value="[]">
                        </div>

                        <!-- Order, Duration, Difficulty -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Lesson Order <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="order" name="order" value="{{ old('order', $course->lessons->count() + 1) }}" required min="1"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            </div>

                            <div>
                                <label for="duration_minutes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Duration (Minutes)
                                </label>
                                <input type="number" id="duration_minutes" name="duration_minutes" min="1"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                    placeholder="e.g., 30">
                            </div>

                            <div>
                                <label for="difficulty" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Difficulty Level
                                </label>
                                <select id="difficulty" name="difficulty"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                    <option value="">Select Level</option>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                            </div>
                        </div>

                        <!-- Status Options -->
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-colors">
                                <input type="checkbox" name="is_preview" value="1"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-5 h-5">
                                <div>
                                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">🎁 Free Preview Lesson</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Allow non-enrolled students to view this lesson</span>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer transition-colors">
                                <input type="checkbox" name="is_published" value="1" checked
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-5 h-5">
                                <div>
                                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">📢 Publish Lesson</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Make this lesson visible to students</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Tab 3: Interactive -->
                    <div class="tab-content" data-tab="interactive">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Interactive Elements</h2>

                        <!-- Vocabulary -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                📚 Vocabulary Words
                            </label>
                            <div class="space-y-2 mb-2" id="vocabulary-list"></div>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" id="vocab-word-input" 
                                    class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                    placeholder="Word">
                                <input type="text" id="vocab-definition-input" 
                                    class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                    placeholder="Definition">
                            </div>
                            <button type="button" id="add-vocabulary-btn" class="mt-2 w-full px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors">
                                Add Vocabulary
                            </button>
                            <input type="hidden" name="vocabulary" id="vocabulary-hidden" value="[]">
                        </div>

                        <!-- Exercises -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                ✍️ Practice Exercises
                            </label>
                            <div class="space-y-2 mb-2" id="exercises-list"></div>
                            <textarea id="exercise-input" rows="3"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="Describe a practice exercise or question..."></textarea>
                            <button type="button" id="add-exercise-btn" class="mt-2 w-full px-4 py-2 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition-colors">
                                Add Exercise
                            </button>
                            <input type="hidden" name="exercises" id="exercises-hidden" value="[]">
                        </div>
                    </div>

                    <!-- Tab 4: Resources -->
                    <div class="tab-content" data-tab="resources">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Additional Resources</h2>

                        <!-- External Resources -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                🔗 External Resources & Links
                            </label>
                            <div class="space-y-2 mb-2" id="resources-list"></div>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" id="resource-title-input" 
                                    class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                    placeholder="Resource title">
                                <input type="url" id="resource-url-input" 
                                    class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                    placeholder="https://...">
                            </div>
                            <button type="button" id="add-resource-btn" class="mt-2 w-full px-4 py-2 bg-teal-600 text-white rounded-xl hover:bg-teal-700 transition-colors">
                                Add Resource
                            </button>
                            <input type="hidden" name="resources" id="resources-hidden" value="[]">
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Add helpful links, articles, or external materials</p>
                        </div>

                        <!-- File Uploads info -->
                        <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-blue-200 dark:border-blue-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">📎 Downloadable Materials</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                Add PDFs, worksheets, and other downloadable materials from the lesson detail page after creation.
                            </p>
                            <div class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span>Files can be uploaded after the lesson is created via the Materials section</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
                        <a href="{{ route('courses.show', $course) }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            Cancel
                        </a>

                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-200">
                            🚀 Create Lesson
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .tab-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-bottom: 2px solid transparent;
            color: #6b7280;
            transition: all 0.2s;
        }

        .tab-button:hover {
            color: #4f46e5;
        }

        .tab-button.active {
            color: #4f46e5;
            border-bottom-color: #4f46e5;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        // Tab Navigation
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.dataset.tab;
                
                // Update buttons
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                // Update content
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                document.querySelector(`.tab-content[data-tab="${tabName}"]`).classList.add('active');
            });
        });

        // Data arrays
        let objectives = [];
        let keyPoints = [];
        let vocabulary = [];
        let exercises = [];
        let resources = [];

        // Objectives Management
        function addObjective() {
            const input = document.getElementById('objective-input');
            const objective = input.value.trim();
            
            if (objective) {
                objectives.push(objective);
                updateObjectivesDisplay();
                input.value = '';
            }
        }

        function updateObjectivesDisplay() {
            const container = document.getElementById('objectives-list');
            container.innerHTML = objectives.map((obj, index) => `
                <div class="flex items-start gap-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="flex-1 text-sm text-gray-700 dark:text-gray-300">${obj}</span>
                    <button type="button" onclick="removeObjective(${index})" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `).join('');
            document.getElementById('objectives-hidden').value = JSON.stringify(objectives);
        }

        function removeObjective(index) {
            objectives.splice(index, 1);
            updateObjectivesDisplay();
        }

        document.getElementById('add-objective-btn').addEventListener('click', addObjective);
        document.getElementById('objective-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                addObjective();
            }
        });

        // Key Points Management
        function addKeyPoint() {
            const input = document.getElementById('keypoint-input');
            const keyPoint = input.value.trim();
            
            if (keyPoint) {
                keyPoints.push(keyPoint);
                updateKeyPointsDisplay();
                input.value = '';
            }
        }

        function updateKeyPointsDisplay() {
            const container = document.getElementById('keypoints-list');
            container.innerHTML = keyPoints.map((point, index) => `
                <div class="flex items-start gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <span class="flex-1 text-sm text-gray-700 dark:text-gray-300">${point}</span>
                    <button type="button" onclick="removeKeyPoint(${index})" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `).join('');
            document.getElementById('keypoints-hidden').value = JSON.stringify(keyPoints);
        }

        function removeKeyPoint(index) {
            keyPoints.splice(index, 1);
            updateKeyPointsDisplay();
        }

        document.getElementById('add-keypoint-btn').addEventListener('click', addKeyPoint);
        document.getElementById('keypoint-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                addKeyPoint();
            }
        });

        // Vocabulary Management
        function addVocabulary() {
            const wordInput = document.getElementById('vocab-word-input');
            const definitionInput = document.getElementById('vocab-definition-input');
            const word = wordInput.value.trim();
            const definition = definitionInput.value.trim();
            
            if (word && definition) {
                vocabulary.push({ word, definition });
                updateVocabularyDisplay();
                wordInput.value = '';
                definitionInput.value = '';
            }
        }

        function updateVocabularyDisplay() {
            const container = document.getElementById('vocabulary-list');
            container.innerHTML = vocabulary.map((item, index) => `
                <div class="flex items-start gap-3 p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl">
                    <div class="flex-1">
                        <div class="font-semibold text-purple-900 dark:text-purple-300">${item.word}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">${item.definition}</div>
                    </div>
                    <button type="button" onclick="removeVocabulary(${index})" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `).join('');
            document.getElementById('vocabulary-hidden').value = JSON.stringify(vocabulary);
        }

        function removeVocabulary(index) {
            vocabulary.splice(index, 1);
            updateVocabularyDisplay();
        }

        document.getElementById('add-vocabulary-btn').addEventListener('click', addVocabulary);

        // Exercises Management
        function addExercise() {
            const input = document.getElementById('exercise-input');
            const exercise = input.value.trim();
            
            if (exercise) {
                exercises.push(exercise);
                updateExercisesDisplay();
                input.value = '';
            }
        }

        function updateExercisesDisplay() {
            const container = document.getElementById('exercises-list');
            container.innerHTML = exercises.map((ex, index) => `
                <div class="flex items-start gap-3 p-3 bg-orange-50 dark:bg-orange-900/20 rounded-xl">
                    <span class="flex-shrink-0 w-6 h-6 bg-orange-600 text-white rounded-full flex items-center justify-center text-xs font-bold">${index + 1}</span>
                    <span class="flex-1 text-sm text-gray-700 dark:text-gray-300">${ex}</span>
                    <button type="button" onclick="removeExercise(${index})" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `).join('');
            document.getElementById('exercises-hidden').value = JSON.stringify(exercises);
        }

        function removeExercise(index) {
            exercises.splice(index, 1);
            updateExercisesDisplay();
        }

        document.getElementById('add-exercise-btn').addEventListener('click', addExercise);

        // Resources Management
        function addResource() {
            const titleInput = document.getElementById('resource-title-input');
            const urlInput = document.getElementById('resource-url-input');
            const title = titleInput.value.trim();
            const url = urlInput.value.trim();
            
            if (title && url) {
                resources.push({ title, url });
                updateResourcesDisplay();
                titleInput.value = '';
                urlInput.value = '';
            }
        }

        function updateResourcesDisplay() {
            const container = document.getElementById('resources-list');
            container.innerHTML = resources.map((res, index) => `
                <div class="flex items-start gap-3 p-3 bg-teal-50 dark:bg-teal-900/20 rounded-xl">
                    <svg class="w-5 h-5 text-teal-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <div class="font-semibold text-gray-900 dark:text-white">${res.title}</div>
                        <a href="${res.url}" target="_blank" class="text-xs text-teal-600 dark:text-teal-400 hover:underline">${res.url}</a>
                    </div>
                    <button type="button" onclick="removeResource(${index})" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `).join('');
            document.getElementById('resources-hidden').value = JSON.stringify(resources);
        }

        function removeResource(index) {
            resources.splice(index, 1);
            updateResourcesDisplay();
        }

        document.getElementById('add-resource-btn').addEventListener('click', addResource);

        // AI Content Generation
        document.getElementById('generate-content').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            
            if (!title) {
                alert('Please enter a lesson title first.');
                return;
            }

            const prompt = `Write a comprehensive lesson content for an English lesson titled "${title}". Use Markdown formatting with headers (##, ###), bullet points, numbered lists, **bold** text, and clear examples. Structure it with:
1. Introduction
2. Main concepts with explanations
3. Examples
4. Practice exercises
5. Summary

Keep it educational, engaging, and well-organized. Target length: 400-600 words.`;
            
            const button = this;
            const originalContent = button.innerHTML;
            button.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
            button.disabled = true;

            fetch('{{ route("ai.generate") }}', {
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
                alert('An error occurred while generating the content.');
            })
            .finally(() => {
                button.innerHTML = originalContent;
                button.disabled = false;
            });
        });
    </script>
</x-app-layout>
