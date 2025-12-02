<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Lesson</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Adding content to <span class="font-medium text-indigo-600">{{ $course->title }}</span></p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('courses.show', $course) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" form="lessonForm" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm transition-colors">
                        Create Lesson
                    </button>
                </div>
            </div>

            <form method="POST" action="{{ route('lessons.store') }}" id="lessonForm">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                <div class="grid grid-cols-12 gap-8">
                    <!-- Left Column: Main Content -->
                    <div class="col-span-12 lg:col-span-8 space-y-6">
                        
                        <!-- Core Content -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                            <div class="space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lesson Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g., Introduction to Grammar"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                </div>

                                <div>
                                    <label for="summary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Summary</label>
                                    <textarea name="summary" id="summary" rows="2" placeholder="Brief overview..."
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">{{ old('summary') }}</textarea>
                                </div>

                                <div>
                                    <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Video URL (Optional)</label>
                                    <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}" placeholder="https://youtube.com/..."
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Editor -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex justify-between items-center mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lesson Content <span class="text-red-500">*</span></label>
                                <button type="button" id="generate-content" class="text-xs text-indigo-600 hover:text-indigo-500 font-medium flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    Generate with AI
                                </button>
                            </div>
                            <textarea name="content" id="content" rows="20" required placeholder="Write your lesson content here (Markdown supported)..."
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono dark:bg-gray-900 dark:border-gray-600 dark:text-white">{{ old('content') }}</textarea>
                        </div>

                        <!-- Interactive Elements -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Interactive Elements</h3>
                            
                            <!-- Vocabulary -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Vocabulary</label>
                                <div class="space-y-2 mb-2" id="vocabulary-list"></div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <input type="text" id="vocab-word-input" placeholder="Word" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                    <input type="text" id="vocab-definition-input" placeholder="Definition" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                </div>
                                <button type="button" id="add-vocabulary-btn" class="mt-2 w-full sm:w-auto px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add Word</button>
                                <input type="hidden" name="vocabulary" id="vocabulary-hidden" value="[]">
                            </div>

                            <!-- Exercises -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Practice Exercises</label>
                                <div class="space-y-2 mb-2" id="exercises-list"></div>
                                <textarea id="exercise-input" rows="2" placeholder="Describe an exercise..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white"></textarea>
                                <button type="button" id="add-exercise-btn" class="mt-2 w-full sm:w-auto px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add Exercise</button>
                                <input type="hidden" name="exercises" id="exercises-hidden" value="[]">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Sidebar Settings -->
                    <div class="col-span-12 lg:col-span-4 space-y-6">
                        
                        <!-- Publishing & Status -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Publishing</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="is_published" name="is_published" type="checkbox" value="1" checked
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_published" class="font-medium text-gray-700 dark:text-gray-300">Published</label>
                                        <p class="text-gray-500 dark:text-gray-400">Visible to students</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="is_preview" name="is_preview" type="checkbox" value="1"
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_preview" class="font-medium text-gray-700 dark:text-gray-300">Free Preview</label>
                                        <p class="text-gray-500 dark:text-gray-400">Publicly accessible</p>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <label for="course_section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section (Optional)</label>
                                    <select name="course_section_id" id="course_section_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                        <option value="">No Section</option>
                                        @foreach($course->sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->title }}</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Organize lessons into sections</p>
                                </div>

                                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order</label>
                                    <input type="number" name="order" id="order" value="{{ $course->lessons->count() + 1 }}" required min="1"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Lesson Metadata -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Metadata</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="duration_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration (Minutes)</label>
                                    <input type="number" name="duration_minutes" id="duration_minutes" min="1" placeholder="e.g. 45"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                </div>

                                <div>
                                    <label for="difficulty" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Difficulty</label>
                                    <select id="difficulty" name="difficulty"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                        <option value="">Select Level</option>
                                        <option value="beginner">Beginner</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="advanced">Advanced</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Learning Objectives -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Objectives</h3>
                            <div class="space-y-2 mb-2" id="objectives-list"></div>
                            <div class="flex gap-2">
                                <input type="text" id="objective-input" placeholder="Add objective..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                <button type="button" id="add-objective-btn" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add</button>
                            </div>
                            <input type="hidden" name="objectives" id="objectives-hidden" value="[]">
                        </div>

                        <!-- Key Points -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Key Points</h3>
                            <div class="space-y-2 mb-2" id="keypoints-list"></div>
                            <div class="flex gap-2">
                                <input type="text" id="keypoint-input" placeholder="Add key point..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                <button type="button" id="add-keypoint-btn" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add</button>
                            </div>
                            <input type="hidden" name="key_points" id="keypoints-hidden" value="[]">
                        </div>

                        <!-- Resources -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Resources</h3>
                            <div class="space-y-2 mb-2" id="resources-list"></div>
                            <div class="space-y-2">
                                <input type="text" id="resource-title-input" placeholder="Title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                <input type="url" id="resource-url-input" placeholder="URL" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                <button type="button" id="add-resource-btn" class="w-full px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add Resource</button>
                            </div>
                            <input type="hidden" name="resources" id="resources-hidden" value="[]">
                        </div>

                        <!-- Teacher Notes -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Teacher Notes</h3>
                            <textarea name="notes" id="notes" rows="4" placeholder="Private notes..."
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize Data
        let objectives = [];
        let keyPoints = [];
        let vocabulary = [];
        let exercises = [];
        let resources = [];

        // Helper to create list items
        function createListItem(text, removeFnIndex, type = 'default') {
            return `
                <div class="flex items-start justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-md text-sm group">
                    <span class="text-gray-700 dark:text-gray-300 break-words">${text}</span>
                    <button type="button" onclick="${removeFnIndex}" class="text-gray-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity ml-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `;
        }

        // Objectives
        function updateObjectivesDisplay() {
            document.getElementById('objectives-list').innerHTML = objectives.map((o, i) => createListItem(o, `removeObjective(${i})`)).join('');
            document.getElementById('objectives-hidden').value = JSON.stringify(objectives);
        }
        function removeObjective(i) { objectives.splice(i, 1); updateObjectivesDisplay(); }
        document.getElementById('add-objective-btn').addEventListener('click', () => {
            const el = document.getElementById('objective-input');
            if(el.value.trim()) { objectives.push(el.value.trim()); el.value=''; updateObjectivesDisplay(); }
        });

        // Key Points
        function updateKeyPointsDisplay() {
            document.getElementById('keypoints-list').innerHTML = keyPoints.map((k, i) => createListItem(k, `removeKeyPoint(${i})`)).join('');
            document.getElementById('keypoints-hidden').value = JSON.stringify(keyPoints);
        }
        function removeKeyPoint(i) { keyPoints.splice(i, 1); updateKeyPointsDisplay(); }
        document.getElementById('add-keypoint-btn').addEventListener('click', () => {
            const el = document.getElementById('keypoint-input');
            if(el.value.trim()) { keyPoints.push(el.value.trim()); el.value=''; updateKeyPointsDisplay(); }
        });

        // Vocabulary
        function updateVocabularyDisplay() {
            document.getElementById('vocabulary-list').innerHTML = vocabulary.map((v, i) => `
                <div class="p-2 bg-gray-50 dark:bg-gray-700/50 rounded-md text-sm group relative">
                    <div class="font-medium text-gray-900 dark:text-white">${v.word}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-xs">${v.definition}</div>
                    <button type="button" onclick="removeVocabulary(${i})" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `).join('');
            document.getElementById('vocabulary-hidden').value = JSON.stringify(vocabulary);
        }
        function removeVocabulary(i) { vocabulary.splice(i, 1); updateVocabularyDisplay(); }
        document.getElementById('add-vocabulary-btn').addEventListener('click', () => {
            const w = document.getElementById('vocab-word-input');
            const d = document.getElementById('vocab-definition-input');
            if(w.value.trim() && d.value.trim()) { vocabulary.push({word: w.value.trim(), definition: d.value.trim()}); w.value=''; d.value=''; updateVocabularyDisplay(); }
        });

        // Exercises
        function updateExercisesDisplay() {
            document.getElementById('exercises-list').innerHTML = exercises.map((e, i) => createListItem(e, `removeExercise(${i})`)).join('');
            document.getElementById('exercises-hidden').value = JSON.stringify(exercises);
        }
        function removeExercise(i) { exercises.splice(i, 1); updateExercisesDisplay(); }
        document.getElementById('add-exercise-btn').addEventListener('click', () => {
            const el = document.getElementById('exercise-input');
            if(el.value.trim()) { exercises.push(el.value.trim()); el.value=''; updateExercisesDisplay(); }
        });

        // Resources
        function updateResourcesDisplay() {
            document.getElementById('resources-list').innerHTML = resources.map((r, i) => `
                <div class="p-2 bg-gray-50 dark:bg-gray-700/50 rounded-md text-sm group relative">
                    <a href="${r.url}" target="_blank" class="font-medium text-indigo-600 hover:underline block truncate pr-6">${r.title}</a>
                    <button type="button" onclick="removeResource(${i})" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `).join('');
            document.getElementById('resources-hidden').value = JSON.stringify(resources);
        }
        function removeResource(i) { resources.splice(i, 1); updateResourcesDisplay(); }
        document.getElementById('add-resource-btn').addEventListener('click', () => {
            const t = document.getElementById('resource-title-input');
            const u = document.getElementById('resource-url-input');
            if(t.value.trim() && u.value.trim()) { resources.push({title: t.value.trim(), url: u.value.trim()}); t.value=''; u.value=''; updateResourcesDisplay(); }
        });

        // AI Generation
        document.getElementById('generate-content').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            if (!title) { alert('Please enter a lesson title first.'); return; }
            
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Generating...';
            btn.disabled = true;

            fetch('{{ route("ai.generate") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ prompt: `Write a lesson content for "${title}".`, provider: 'gemini' })
            })
            .then(r => r.json())
            .then(data => {
                if (data.content) document.getElementById('content').value = data.content;
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    </script>
</x-app-layout>
