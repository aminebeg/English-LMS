<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Course</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Update <span class="font-medium text-indigo-600">{{ $course->title }}</span></p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('courses.show', $course) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" form="courseForm" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm transition-colors">
                        Save Changes
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-8">
                <!-- Sidebar Navigation -->
                <div class="col-span-12 lg:col-span-3">
                    <nav class="sticky top-8 space-y-1" aria-label="Sidebar">
                        <a href="#basic-info" class="group flex items-center px-3 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-md dark:bg-indigo-900/50 dark:text-indigo-300" onclick="setActiveNav(this)">
                            <span class="truncate">Basic Information</span>
                        </a>
                        <a href="#details" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white" onclick="setActiveNav(this)">
                            <span class="truncate">Course Details</span>
                        </a>
                        <a href="#curriculum" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white" onclick="setActiveNav(this)">
                            <span class="truncate">Curriculum</span>
                        </a>
                        <a href="#media" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white" onclick="setActiveNav(this)">
                            <span class="truncate">Media & Tags</span>
                        </a>
                        <a href="#pricing" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white" onclick="setActiveNav(this)">
                            <span class="truncate">Pricing & Settings</span>
                        </a>
                        
                        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('courses.students.index', $course) }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white">
                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                                <span class="truncate">Manage Students</span>
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="col-span-12 lg:col-span-9 space-y-8">
                    <form method="POST" action="{{ route('courses.update', $course) }}" enctype="multipart/form-data" id="courseForm">
                        @csrf
                        @method('PUT')

                        <!-- Section: Basic Information -->
                        <div id="basic-info" class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 scroll-mt-24">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Basic Information</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Core details about your course.</p>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category <span class="text-red-500">*</span></label>
                                        <select id="category" name="category" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                            <option value="">Select Category</option>
                                            @foreach(['Business English', 'Academic English', 'Conversational English', 'Grammar & Writing', 'Test Preparation', 'Pronunciation', 'Vocabulary', 'Literature', 'Creative Writing', 'Other'] as $cat)
                                                <option value="{{ $cat }}" {{ old('category', $course->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Target Audience <span class="text-red-500">*</span></label>
                                        <select id="type" name="type" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                            <option value="adult" {{ old('type', $course->type) == 'adult' ? 'selected' : '' }}>Adults</option>
                                            <option value="kid" {{ old('type', $course->type) == 'kid' ? 'selected' : '' }}>Kids (6-12)</option>
                                            <option value="researcher" {{ old('type', $course->type) == 'researcher' ? 'selected' : '' }}>Researchers/Academic</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CEFR Level</label>
                                        <select id="level" name="level"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                            <option value="">No specific level</option>
                                            @foreach(['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $lvl)
                                                <option value="{{ $lvl }}" {{ old('level', $course->level) == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="difficulty" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Difficulty</label>
                                        <select id="difficulty" name="difficulty"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                            <option value="">Select Difficulty</option>
                                            @foreach(['beginner', 'intermediate', 'advanced', 'expert'] as $diff)
                                                <option value="{{ $diff }}" {{ old('difficulty', $course->difficulty) == $diff ? 'selected' : '' }}>{{ ucfirst($diff) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Language</label>
                                        <input type="text" id="language" name="language" value="{{ old('language', $course->language) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="max_students" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Students</label>
                                        <input type="number" id="max_students" name="max_students" min="1" value="{{ old('max_students', $course->max_students) }}" placeholder="Unlimited"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Details -->
                        <div id="details" class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 scroll-mt-24">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Course Details</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">In-depth information about the curriculum.</p>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description <span class="text-red-500">*</span></label>
                                        <button type="button" id="generate-description" class="text-xs text-indigo-600 hover:text-indigo-500 font-medium">✨ Generate with AI</button>
                                    </div>
                                    <textarea id="description" name="description" rows="5" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">{{ old('description', $course->description) }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Learning Outcomes</label>
                                    <div class="space-y-2 mb-2" id="outcomes-list"></div>
                                    <div class="flex gap-2">
                                        <input type="text" id="outcome-input" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white" placeholder="Add an outcome...">
                                        <button type="button" id="add-outcome-btn" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add</button>
                                    </div>
                                    <input type="hidden" name="learning_outcomes" id="outcomes-hidden" value="{{ json_encode($course->learning_outcomes ?? []) }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prerequisites</label>
                                    <div class="space-y-2 mb-2" id="prerequisites-list"></div>
                                    <div class="flex gap-2">
                                        <input type="text" id="prerequisite-input" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white" placeholder="Add a prerequisite...">
                                        <button type="button" id="add-prerequisite-btn" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add</button>
                                    </div>
                                    <input type="hidden" name="prerequisites" id="prerequisites-hidden" value="{{ json_encode($course->prerequisites ?? []) }}">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="duration_weeks" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration (Weeks)</label>
                                        <input type="number" id="duration_weeks" name="duration_weeks" min="1" value="{{ old('duration_weeks', $course->duration_weeks) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="estimated_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estimated Hours</label>
                                        <input type="number" id="estimated_hours" name="estimated_hours" min="1" value="{{ old('estimated_hours', $course->estimated_hours) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                    </div>
                                </div>

                                <div>
                                    <label for="instructor_bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instructor Bio</label>
                                    <textarea id="instructor_bio" name="instructor_bio" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">{{ old('instructor_bio', $course->instructor_bio) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Curriculum -->
                        <div id="curriculum" class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 scroll-mt-24">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Curriculum</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage sections and structure.</p>
                                </div>
                                <button type="button" onclick="document.getElementById('add-section-modal').classList.remove('hidden')" class="px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors">
                                    + Add Section
                                </button>
                            </div>
                            <div class="p-6 space-y-4">
                                @if($course->sections->isEmpty())
                                    <div class="text-center py-8 text-gray-500 dark:text-gray-400 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                                        <p>No sections yet. Create a section to organize your lessons.</p>
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        @foreach($course->sections as $section)
                                            <div class="border dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-700/30 flex justify-between items-center group hover:border-indigo-300 dark:hover:border-indigo-700 transition-colors">
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $section->title }}</h4>
                                                    @if($section->description)
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $section->description }}</p>
                                                    @endif
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">{{ $section->lessons->count() }} lessons</span>
                                                </div>
                                                <div class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <button type="button" onclick="editSection({{ $section->id }}, '{{ addslashes($section->title) }}', '{{ addslashes($section->description) }}')" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">Edit</button>
                                                    <form action="{{ route('sections.destroy', $section) }}" method="POST" class="inline" onsubmit="return confirm('Delete this section? Lessons will be kept but unassigned.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Section: Media & Tags -->
                        <div id="media" class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 scroll-mt-24">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Media & Tags</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Visuals and categorization.</p>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course Thumbnail</label>
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0 h-24 w-40 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600">
                                            @if($course->thumbnail)
                                                <img id="thumbnail-preview-img" src="{{ Storage::url($course->thumbnail) }}" alt="Thumbnail" class="h-full w-full object-cover">
                                            @else
                                                <div id="thumbnail-placeholder" class="h-full w-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/50 dark:file:text-indigo-300">
                                            <p class="mt-1 text-xs text-gray-500">Recommended: 1280x720px, Max 2MB</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags</label>
                                    <div class="flex gap-2 mb-2">
                                        <input type="text" id="tag-input" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white" placeholder="Add a tag...">
                                        <button type="button" id="add-tag-btn" class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 border border-gray-300 text-sm font-medium">Add</button>
                                    </div>
                                    <div id="tags-container" class="flex flex-wrap gap-2"></div>
                                    <input type="hidden" name="tags" id="tags-hidden" value="{{ json_encode($course->tags ?? []) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Section: Pricing & Settings -->
                        <div id="pricing" class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 scroll-mt-24">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Pricing & Settings</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Monetization and publishing controls.</p>
                            </div>
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price ($) <span class="text-red-500">*</span></label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" name="price" id="price" value="{{ old('price', $course->price) }}" step="0.01" min="0" required
                                                class="block w-full pl-7 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="original_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Original Price ($)</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" name="original_price" id="original_price" value="{{ old('original_price', $course->original_price) }}" step="0.01" min="0"
                                                class="block w-full pl-7 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="discount_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount (%)</label>
                                        <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $course->discount_percentage) }}" min="0" max="100"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                    </div>
                                </div>

                                <div class="space-y-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="has_payment_plan" name="has_payment_plan" type="checkbox" value="1" {{ old('has_payment_plan', $course->has_payment_plan) ? 'checked' : '' }}
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="has_payment_plan" class="font-medium text-gray-700 dark:text-gray-300">Offer Payment Plan</label>
                                            <p class="text-gray-500 dark:text-gray-400">Allow students to pay in installments.</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="has_certificate" name="has_certificate" type="checkbox" value="1" {{ old('has_certificate', $course->has_certificate) ? 'checked' : '' }}
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="has_certificate" class="font-medium text-gray-700 dark:text-gray-300">Award Certificate</label>
                                            <p class="text-gray-500 dark:text-gray-400">Grant a certificate upon course completion.</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="is_published" name="is_published" type="checkbox" value="1" {{ old('is_published', $course->is_published) ? 'checked' : '' }}
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="is_published" class="font-medium text-gray-700 dark:text-gray-300">Published</label>
                                            <p class="text-gray-500 dark:text-gray-400">Make this course visible to students.</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="is_featured" class="font-medium text-gray-700 dark:text-gray-300">Featured</label>
                                            <p class="text-gray-500 dark:text-gray-400">Highlight this course on the homepage.</p>
                                        </div>
                                    </div>

                                    <div class="pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                                        <h4 class="text-sm font-medium text-red-600 dark:text-red-400 mb-4">Danger Zone</h4>
                                        <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                            <div>
                                                <h5 class="text-sm font-medium text-red-800 dark:text-red-200">Delete Course</h5>
                                                <p class="text-xs text-red-600 dark:text-red-300 mt-1">Once deleted, this course cannot be recovered.</p>
                                            </div>
                                            <button type="button" onclick="if(confirm('Are you sure you want to delete this course? This action cannot be undone.')) document.getElementById('delete-course-form').submit();" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Delete Course
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <form id="delete-course-form" action="{{ route('courses.destroy', $course) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Navigation Active State
        function setActiveNav(element) {
            document.querySelectorAll('nav a').forEach(el => {
                el.classList.remove('bg-indigo-50', 'text-indigo-600', 'dark:bg-indigo-900/50', 'dark:text-indigo-300');
                el.classList.add('text-gray-600', 'hover:bg-gray-50', 'dark:text-gray-400');
            });
            element.classList.remove('text-gray-600', 'hover:bg-gray-50', 'dark:text-gray-400');
            element.classList.add('bg-indigo-50', 'text-indigo-600', 'dark:bg-indigo-900/50', 'dark:text-indigo-300');
        }

        // Highlight active section on scroll
        window.addEventListener('scroll', () => {
            let current = '';
            const sections = document.querySelectorAll('div[id]');
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (scrollY >= sectionTop - 150) {
                    current = section.getAttribute('id');
                }
            });

            if (current) {
                document.querySelectorAll('nav a').forEach(a => {
                    a.classList.remove('bg-indigo-50', 'text-indigo-600', 'dark:bg-indigo-900/50', 'dark:text-indigo-300');
                    a.classList.add('text-gray-600');
                    if (a.getAttribute('href') === '#' + current) {
                        a.classList.remove('text-gray-600');
                        a.classList.add('bg-indigo-50', 'text-indigo-600', 'dark:bg-indigo-900/50', 'dark:text-indigo-300');
                    }
                });
            }
        });

        // Initialize Data
        let tags = JSON.parse(document.getElementById('tags-hidden').value || '[]');
        let outcomes = JSON.parse(document.getElementById('outcomes-hidden').value || '[]');
        let prerequisites = JSON.parse(document.getElementById('prerequisites-hidden').value || '[]');

        updateTagsDisplay();
        updateOutcomesDisplay();
        updatePrerequisitesDisplay();

        // Tag Logic
        function updateTagsDisplay() {
            const container = document.getElementById('tags-container');
            container.innerHTML = tags.map((tag, index) => `
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                    ${tag}
                    <button type="button" onclick="removeTag(${index})" class="ml-1.5 inline-flex items-center justify-center w-4 h-4 rounded-full text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none">
                        <span class="sr-only">Remove tag</span>
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                </span>
            `).join('');
            document.getElementById('tags-hidden').value = JSON.stringify(tags);
        }

        function removeTag(index) { tags.splice(index, 1); updateTagsDisplay(); }
        document.getElementById('add-tag-btn').addEventListener('click', () => {
            const input = document.getElementById('tag-input');
            if (input.value.trim()) { tags.push(input.value.trim()); input.value = ''; updateTagsDisplay(); }
        });

        // Outcome Logic
        function updateOutcomesDisplay() {
            const container = document.getElementById('outcomes-list');
            container.innerHTML = outcomes.map((item, index) => `
                <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-md text-sm">
                    <span>${item}</span>
                    <button type="button" onclick="removeOutcome(${index})" class="text-red-500 hover:text-red-700">Remove</button>
                </div>
            `).join('');
            document.getElementById('outcomes-hidden').value = JSON.stringify(outcomes);
        }
        function removeOutcome(index) { outcomes.splice(index, 1); updateOutcomesDisplay(); }
        document.getElementById('add-outcome-btn').addEventListener('click', () => {
            const input = document.getElementById('outcome-input');
            if (input.value.trim()) { outcomes.push(input.value.trim()); input.value = ''; updateOutcomesDisplay(); }
        });

        // Prerequisite Logic
        function updatePrerequisitesDisplay() {
            const container = document.getElementById('prerequisites-list');
            container.innerHTML = prerequisites.map((item, index) => `
                <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-md text-sm">
                    <span>${item}</span>
                    <button type="button" onclick="removePrerequisite(${index})" class="text-red-500 hover:text-red-700">Remove</button>
                </div>
            `).join('');
            document.getElementById('prerequisites-hidden').value = JSON.stringify(prerequisites);
        }
        function removePrerequisite(index) { prerequisites.splice(index, 1); updatePrerequisitesDisplay(); }
        document.getElementById('add-prerequisite-btn').addEventListener('click', () => {
            const input = document.getElementById('prerequisite-input');
            if (input.value.trim()) { prerequisites.push(input.value.trim()); input.value = ''; updatePrerequisitesDisplay(); }
        });

        // Thumbnail Preview
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('thumbnail-preview-img');
                    if (img) {
                        img.src = e.target.result;
                    } else {
                        // Replace placeholder with image
                        const container = document.getElementById('thumbnail-placeholder').parentNode;
                        container.innerHTML = `<img id="thumbnail-preview-img" src="${e.target.result}" alt="Thumbnail" class="h-full w-full object-cover">`;
                    }
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // AI Generation
        document.getElementById('generate-description').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            if (!title) { alert('Please enter a course title first.'); return; }
            
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Generating...';
            btn.disabled = true;

            fetch('{{ route("ai.generate") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ prompt: `Write a course description for "${title}".`, provider: 'gemini' })
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
        // Section Modal Functions
        function editSection(id, title, description) {
            document.getElementById('edit-section-id').value = id;
            document.getElementById('edit-section-title').value = title;
            document.getElementById('edit-section-description').value = description;
            document.getElementById('edit-section-form').action = `/sections/${id}`;
            document.getElementById('edit-section-modal').classList.remove('hidden');
        }
    </script>

    <!-- Add Section Modal -->
    <div id="add-section-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Add New Section</h3>
                <button type="button" onclick="document.getElementById('add-section-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('courses.sections.store', $course) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="section-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="section-title" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="section-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="section-description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('add-section-modal').classList.add('hidden')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Create Section
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Section Modal -->
    <div id="edit-section-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Edit Section</h3>
                <button type="button" onclick="document.getElementById('edit-section-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="edit-section-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-section-id">
                <div class="space-y-4">
                    <div>
                        <label for="edit-section-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Section Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="edit-section-title" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="edit-section-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="edit-section-description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('edit-section-modal').classList.add('hidden')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Update Section
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
