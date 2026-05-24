<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Create New Lesson</h1>
                    <p class="text-sm text-gray-500">Adding content to <span class="font-medium text-indigo-600">{{ $course->title }}</span></p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('courses.show', $course) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 bg-gray-800 text-gray-300 border-gray-600 hover:bg-gray-700 transition-colors">
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
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                            <div class="space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Lesson Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g., Introduction to Grammar"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg bg-gray-900 border-gray-600 text-white">
                                </div>

                                <div>
                                    <label for="summary" class="block text-sm font-medium text-gray-700">Summary</label>
                                    <textarea name="summary" id="summary" rows="2" placeholder="Brief overview..."
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">{{ old('summary') }}</textarea>
                                </div>

                                <div>
                                    <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL (Optional)</label>
                                    <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}" placeholder="https://youtube.com/..."
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Block Editor -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-sm font-medium text-gray-700">Lesson Content</label>
                                <div class="flex gap-2">
                                    <button type="button" id="generate-outline" class="text-xs text-indigo-600 hover:text-indigo-500 font-medium flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        Generate Outline
                                    </button>
                                </div>
                            </div>

                            <!-- Block Container -->
                            <div id="blocks-container" class="space-y-4 min-h-[300px] pb-12">
                                <!-- Blocks will be injected here -->
                                <div class="text-center py-10 text-gray-400 text-gray-500 italic" id="empty-state">
                                    Start by adding a content block below
                                </div>
                            </div>

                            <!-- Add Block Toolbar -->
                            <div class="mt-4 pt-4 border-t border-gray-100 border-gray-700">
                                <p class="text-xs font-medium text-gray-500 mb-3 uppercase tracking-wider">Add Content Block</p>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" onclick="addBlock('heading')" class="flex items-center gap-2 px-3 py-2 bg-gray-50 bg-gray-700 hover:bg-gray-100 hover:bg-gray-600 rounded-md text-sm text-gray-700 text-gray-200 transition-colors border border-gray-200 border-gray-600">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                                        Heading
                                    </button>
                                    <button type="button" onclick="addBlock('text')" class="flex items-center gap-2 px-3 py-2 bg-gray-50 bg-gray-700 hover:bg-gray-100 hover:bg-gray-600 rounded-md text-sm text-gray-700 text-gray-200 transition-colors border border-gray-200 border-gray-600">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Text
                                    </button>
                                    <button type="button" onclick="addBlock('image')" class="flex items-center gap-2 px-3 py-2 bg-gray-50 bg-gray-700 hover:bg-gray-100 hover:bg-gray-600 rounded-md text-sm text-gray-700 text-gray-200 transition-colors border border-gray-200 border-gray-600">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Image
                                    </button>
                                    <button type="button" onclick="addBlock('video')" class="flex items-center gap-2 px-3 py-2 bg-gray-50 bg-gray-700 hover:bg-gray-100 hover:bg-gray-600 rounded-md text-sm text-gray-700 text-gray-200 transition-colors border border-gray-200 border-gray-600">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        Video
                                    </button>
                                    <button type="button" onclick="addBlock('code')" class="flex items-center gap-2 px-3 py-2 bg-gray-50 bg-gray-700 hover:bg-gray-100 hover:bg-gray-600 rounded-md text-sm text-gray-700 text-gray-200 transition-colors border border-gray-200 border-gray-600">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                        Code
                                    </button>
                                    <button type="button" onclick="addBlock('note')" class="flex items-center gap-2 px-3 py-2 bg-gray-50 bg-gray-700 hover:bg-gray-100 hover:bg-gray-600 rounded-md text-sm text-gray-700 text-gray-200 transition-colors border border-gray-200 border-gray-600">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Note
                                    </button>
                                    <button type="button" onclick="addBlock('audio')" class="flex items-center gap-2 px-3 py-2 bg-gray-50 bg-gray-700 hover:bg-gray-100 hover:bg-gray-600 rounded-md text-sm text-gray-700 text-gray-200 transition-colors border border-gray-200 border-gray-600">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                        Audio
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Hidden input to store JSON content -->
                            <input type="hidden" name="content" id="content-json">
                        </div>

                        <!-- Interactive Elements -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Interactive Elements</h3>
                            
                            <!-- Vocabulary -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Vocabulary</label>
                                <div class="space-y-2 mb-2" id="vocabulary-list"></div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <input type="text" id="vocab-word-input" placeholder="Word" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                    <input type="text" id="vocab-definition-input" placeholder="Definition" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                </div>
                                <button type="button" id="add-vocabulary-btn" class="mt-2 w-full sm:w-auto px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add Word</button>
                                <input type="hidden" name="vocabulary" id="vocabulary-hidden" value="[]">
                            </div>

                            <!-- Exercises -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Practice Exercises</label>
                                <div class="space-y-2 mb-2" id="exercises-list"></div>
                                <textarea id="exercise-input" rows="2" placeholder="Describe an exercise..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white"></textarea>
                                <button type="button" id="add-exercise-btn" class="mt-2 w-full sm:w-auto px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add Exercise</button>
                                <input type="hidden" name="exercises" id="exercises-hidden" value="[]">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Sidebar Settings -->
                    <div class="col-span-12 lg:col-span-4 space-y-6">
                        
                        <!-- Publishing & Status -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Publishing</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="is_published" name="is_published" type="checkbox" value="1" checked
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_published" class="font-medium text-gray-700">Published</label>
                                        <p class="text-gray-500">Visible to students</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="is_preview" name="is_preview" type="checkbox" value="1"
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_preview" class="font-medium text-gray-700">Free Preview</label>
                                        <p class="text-gray-500">Publicly accessible</p>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100 border-gray-700">
                                    <label for="course_section_id" class="block text-sm font-medium text-gray-700">Section (Optional)</label>
                                    <select name="course_section_id" id="course_section_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                        <option value="">No Section</option>
                                        @foreach($course->sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->title }}</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Organize lessons into sections</p>
                                </div>

                                <div class="pt-4 border-t border-gray-100 border-gray-700">
                                    <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                                    <input type="number" name="order" id="order" value="{{ $course->lessons->count() + 1 }}" required min="1"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Lesson Metadata -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Metadata</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Duration (Minutes)</label>
                                    <input type="number" name="duration_minutes" id="duration_minutes" min="1" placeholder="e.g. 45"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                </div>

                                <div>
                                    <label for="difficulty" class="block text-sm font-medium text-gray-700">Difficulty</label>
                                    <select id="difficulty" name="difficulty"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                        <option value="">Select Level</option>
                                        <option value="beginner">Beginner</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="advanced">Advanced</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Learning Objectives -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Objectives</h3>
                            <div class="space-y-2 mb-2" id="objectives-list"></div>
                            <div class="flex gap-2">
                                <input type="text" id="objective-input" placeholder="Add objective..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                <button type="button" id="add-objective-btn" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add</button>
                            </div>
                            <input type="hidden" name="objectives" id="objectives-hidden" value="[]">
                        </div>

                        <!-- Key Points -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Key Points</h3>
                            <div class="space-y-2 mb-2" id="keypoints-list"></div>
                            <div class="flex gap-2">
                                <input type="text" id="keypoint-input" placeholder="Add key point..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                <button type="button" id="add-keypoint-btn" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add</button>
                            </div>
                            <input type="hidden" name="key_points" id="keypoints-hidden" value="[]">
                        </div>

                        <!-- Resources -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Resources</h3>
                            <div class="space-y-2 mb-2" id="resources-list"></div>
                            <div class="space-y-2">
                                <input type="text" id="resource-title-input" placeholder="Title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                <input type="url" id="resource-url-input" placeholder="URL" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">
                                <button type="button" id="add-resource-btn" class="w-full px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add Resource</button>
                            </div>
                            <input type="hidden" name="resources" id="resources-hidden" value="[]">
                        </div>

                        <!-- Teacher Notes -->
                        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Teacher Notes</h3>
                            <textarea name="notes" id="notes" rows="4" placeholder="Private notes..."
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-900 border-gray-600 text-white">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Styles -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar { background-color: #f9fafb; border-color: #e5e7eb !important; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; }
        .ql-container { background-color: #ffffff; border-color: #e5e7eb !important; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; font-family: inherit !important; color: inherit; }
        .ql-stroke { stroke: #4b5563 !important; }
        .ql-fill { fill: #374151 !important; }
        .ql-picker { color: #374151 !important; }
        .block-handle { cursor: grab; }
        .block-handle:active { cursor: grabbing; }
        .sortable-ghost { opacity: 0.4; }
    </style>

    <!-- Scripts -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <script>
        // Block Editor Logic
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('blocks-container');
            const emptyState = document.getElementById('empty-state');
            let blockCount = 0;
            let editors = {};

            // Initialize Sortable
            new Sortable(container, {
                animation: 150,
                handle: '.block-handle',
                ghostClass: 'sortable-ghost',
                onEnd: function() {
                    // Optional: Auto-save or update order
                }
            });

            // Block Templates
            const templates = {
                heading: (id) => `
                    <div class="flex items-center gap-4 mb-2">
                        <select class="block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-700 border-gray-600 text-white" onchange="updateHeadingLevel('${id}', this.value)">
                            <option value="h2">H2</option>
                            <option value="h3">H3</option>
                            <option value="h4">H4</option>
                        </select>
                        <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg font-bold bg-gray-700 border-gray-600 text-white" placeholder="Heading Text" data-type="content">
                    </div>
                `,
                text: (id) => `
                    <div class="bg-white">
                        <div id="editor-${id}" class="h-48"></div>
                    </div>
                `,
                image: (id) => `
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <input type="text" id="img-url-${id}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-700 border-gray-600 text-white" placeholder="Image URL or upload a file" data-type="src">
                            <input type="file" id="img-file-${id}" accept="image/*" class="hidden" onchange="handleMediaUpload('${id}', 'image', this)">
                            <button type="button" onclick="document.getElementById('img-file-${id}').click()" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition-colors whitespace-nowrap">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                Upload
                            </button>
                        </div>
                        <div id="img-progress-${id}" class="hidden">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full transition-all" style="width: 0%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Uploading...</p>
                        </div>
                        <div id="img-preview-${id}" class="hidden mt-2">
                            <img src="" alt="Preview" class="max-h-48 rounded-lg border border-gray-200">
                        </div>
                        <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-700 border-gray-600 text-white" placeholder="Image Caption (Alt Text)" data-type="caption">
                    </div>
                `,
                video: (id) => `
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <input type="text" id="vid-url-${id}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-700 border-gray-600 text-white" placeholder="Video URL (YouTube, Vimeo) or upload MP4" data-type="src">
                            <input type="file" id="vid-file-${id}" accept="video/*" class="hidden" onchange="handleMediaUpload('${id}', 'video', this)">
                            <button type="button" onclick="document.getElementById('vid-file-${id}').click()" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition-colors whitespace-nowrap">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                Upload
                            </button>
                        </div>
                        <div id="vid-progress-${id}" class="hidden">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full transition-all" style="width: 0%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Uploading...</p>
                        </div>
                        <div class="text-xs text-gray-500">Supported: YouTube, Vimeo, or upload MP4/WebM files</div>
                    </div>
                `,
                code: (id) => `
                    <div class="space-y-2">
                        <select class="block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-700 border-gray-600 text-white" data-type="language">
                            <option value="javascript">JavaScript</option>
                            <option value="php">PHP</option>
                            <option value="html">HTML</option>
                            <option value="css">CSS</option>
                            <option value="python">Python</option>
                        </select>
                        <textarea class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono bg-gray-700 border-gray-600 text-white" rows="6" placeholder="Paste code here..." data-type="code"></textarea>
                    </div>
                `,
                note: (id) => `
                    <div class="flex gap-3 p-4 bg-yellow-50 bg-yellow-900/20 border-l-4 border-yellow-400 rounded-r-md">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <textarea class="block w-full bg-transparent border-0 p-0 text-yellow-800 text-yellow-200 placeholder-yellow-500 focus:ring-0 sm:text-sm" rows="2" placeholder="Note content..." data-type="content"></textarea>
                        </div>
                    </div>
                `,
                audio: (id) => `
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <input type="text" id="aud-url-${id}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-700 border-gray-600 text-white" placeholder="Audio URL or upload a file" data-type="src">
                            <input type="file" id="aud-file-${id}" accept="audio/*" class="hidden" onchange="handleMediaUpload('${id}', 'audio', this)">
                            <button type="button" onclick="document.getElementById('aud-file-${id}').click()" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition-colors whitespace-nowrap">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                Upload
                            </button>
                        </div>
                        <div id="aud-progress-${id}" class="hidden">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full transition-all" style="width: 0%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Uploading...</p>
                        </div>
                        <div id="aud-player-${id}" class="hidden mt-2">
                            <audio controls class="w-full">
                                <source src="" type="audio/mpeg">
                            </audio>
                        </div>
                        <div class="text-xs text-gray-500">Supported: MP3, WAV, OGG formats</div>
                    </div>
                `
            };

            // Add Block Function
            window.addBlock = function(type, data = null) {
                const id = 'block-' + Date.now() + '-' + Math.floor(Math.random() * 1000);
                const block = document.createElement('div');
                block.className = 'group relative bg-white rounded-lg border border-gray-200 p-4 hover:border-indigo-300 hover:border-indigo-700 transition-all';
                block.dataset.id = id;
                block.dataset.type = type;

                block.innerHTML = `
                    <div class="absolute left-0 top-0 bottom-0 w-8 flex items-center justify-center cursor-move block-handle opacity-0 group-hover:opacity-100 transition-opacity bg-gray-50 bg-gray-700/50 rounded-l-lg border-r border-gray-200">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                    </div>
                    <div class="pl-6 pr-8">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">${type}</span>
                            <button type="button" onclick="removeBlock('${id}')" class="text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="block-content">
                            ${templates[type](id)}
                        </div>
                    </div>
                `;

                container.appendChild(block);
                emptyState.style.display = 'none';

                // Initialize specific block types
                if (type === 'text') {
                    const quill = new Quill(`#editor-${id}`, {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                [{ 'color': [] }, { 'background': [] }],
                                ['link', 'clean']
                            ]
                        }
                    });
                    editors[id] = quill;
                    
                    if (data && data.content) {
                        quill.root.innerHTML = data.content;
                    }
                } else if (data) {
                    // Populate other block types
                    const inputs = block.querySelectorAll('[data-type]');
                    inputs.forEach(input => {
                        const key = input.dataset.type;
                        if (data[key]) input.value = data[key];
                    });
                }
            };

            // Remove Block Function
            window.removeBlock = function(id) {
                const block = document.querySelector(`[data-id="${id}"]`);
                if (block) {
                    if (editors[id]) delete editors[id];
                    block.remove();
                    if (container.children.length <= 1) emptyState.style.display = 'block';
                }
            };

            // Function to collect content blocks into JSON
            window.collectContentBlocks = function() {
                const blocks = [];
                const blockElements = container.querySelectorAll('[data-id]');

                blockElements.forEach(el => {
                    const id = el.dataset.id;
                    const type = el.dataset.type;
                    let content = {};

                    if (type === 'text') {
                        content.content = editors[id].root.innerHTML;
                    } else {
                        const inputs = el.querySelectorAll('[data-type]');
                        inputs.forEach(input => {
                            content[input.dataset.type] = input.value;
                        });
                        
                        // Special handling for heading level
                        if (type === 'heading') {
                            const select = el.querySelector('select');
                            if (select) content.level = select.value;
                        }
                    }

                    blocks.push({ type, data: content });
                });

                return blocks;
            };

            // Form Submission Handler
            document.getElementById('lessonForm').addEventListener('submit', function(e) {
                const blocks = collectContentBlocks();
                
                // VALIDATION: Prevent empty lesson submissions
                if (blocks.length === 0) {
                    e.preventDefault();
                    alert('❌ Please add at least one content block to your lesson!\n\nYour lesson needs content for students to learn from.');
                    return false;
                }

                // Set the JSON value
                document.getElementById('content-json').value = JSON.stringify(blocks);
            });

            // Load existing content if any (for edit mode)
            const existingContent = @json(old('content', isset($lesson) ? $lesson->content : '[]'));
            try {
                const parsed = typeof existingContent === 'string' ? JSON.parse(existingContent) : existingContent;
                if (Array.isArray(parsed) && parsed.length > 0) {
                    parsed.forEach(block => addBlock(block.type, block.data));
                }
            } catch (e) {
                console.log('No structured content found, or legacy content');
                // Handle legacy content (plain text)
                if (existingContent && typeof existingContent === 'string' && existingContent.length > 0 && existingContent !== '[]') {
                    addBlock('text', { content: existingContent });
                }
            }

            // Media Upload Handler
            window.handleMediaUpload = async function(blockId, mediaType, fileInput) {
                const file = fileInput.files[0];
                if (!file) return;

                // Get prefix based on media type
                const prefix = mediaType === 'image' ? 'img' : mediaType === 'video' ? 'vid' : 'aud';
                const urlInput = document.getElementById(`${prefix}-url-${blockId}`);
                const progressDiv = document.getElementById(`${prefix}-progress-${blockId}`);
                const progressBar = progressDiv?.querySelector('div > div');

                // Show progress
                if (progressDiv) {
                    progressDiv.classList.remove('hidden');
                    if (progressBar) progressBar.style.width = '10%';
                }

                try {
                    // Create FormData
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('type', mediaType);

                    // Upload file
                    const response = await fetch('{{ route("media.upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    if (progressBar) progressBar.style.width = '90%';

                    const data = await response.json();

                    if (data.success && data.url) {
                        // Set the URL in the input
                        urlInput.value = data.url;

                        // Show preview for images
                        if (mediaType === 'image') {
                            const preview = document.getElementById(`${prefix}-preview-${blockId}`);
                            if (preview) {
                                const img = preview.querySelector('img');
                                if (img) {
                                    img.src = data.url;
                                    preview.classList.remove('hidden');
                                }
                            }
                        }

                        // Show player for audio
                        if (mediaType === 'audio') {
                            const player = document.getElementById(`${prefix}-player-${blockId}`);
                            if (player) {
                                const source = player.querySelector('source');
                                if (source) {
                                    source.src = data.url;
                                    player.querySelector('audio').load();
                                    player.classList.remove('hidden');
                                }
                            }
                        }

                        if (progressBar) progressBar.style.width = '100%';

                        // Hide progress after a delay
                        setTimeout(() => {
                            if (progressDiv) progressDiv.classList.add('hidden');
                        }, 1000);

                        // Show success message
                        showNotification('File uploaded successfully!', 'success');
                    } else {
                        throw new Error(data.error || 'Upload failed');
                    }
                } catch (error) {
                    console.error('Upload error:', error);
                    showNotification('Upload failed: ' + error.message, 'error');
                    if (progressDiv) progressDiv.classList.add('hidden');
                }

                // Reset file input
                fileInput.value = '';
            };

            // Simple notification function
            function showNotification(message, type = 'info') {
                const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
                const notification = document.createElement('div');
                notification.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300`;
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }
        });
    </script>
</x-app-layout>

