<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Material to') }} {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('materials.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Material Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Type')" />
                            <select id="type" name="type"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>
                                <option value="">Select a type...</option>
                                <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video</option>
                                <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>Text</option>
                                <option value="audio" {{ old('type') === 'audio' ? 'selected' : '' }}>Audio</option>
                                <option value="file" {{ old('type') === 'file' ? 'selected' : '' }}>File</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="mb-4" id="content-section" style="display: none;">
                            <x-input-label for="content" :value="__('Content (URL or Text)')" />
                            <textarea id="content" name="content" rows="6"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('content') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">For video/audio, enter the URL. For text, enter the
                                content.</p>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="mb-4" id="file-section" style="display: none;">
                            <x-input-label for="file" :value="__('Upload File')" />
                            <input id="file"
                                class="block mt-1 w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-100"
                                type="file" name="file" />
                            <p class="text-xs text-gray-500 mt-1">Max size: 10MB. Allowed: PDFs, Documents, Images,
                                ZIPs.</p>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('lessons.show', $lesson) }}"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Cancel
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Create Material') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide content or file sections based on type
        const typeSelect = document.getElementById('type');
        const contentSection = document.getElementById('content-section');
        const fileSection = document.getElementById('file-section');
        const contentField = document.querySelector('textarea[name="content"]');
        const fileField = document.getElementById('file');

        function updateFieldVisibility() {
            const selectedType = typeSelect.value;

            if (selectedType === 'file') {
                contentSection.style.display = 'none';
                fileSection.style.display = 'block';
                contentField.removeAttribute('required');
                fileField.setAttribute('required', 'required');
            } else if (selectedType === 'video' || selectedType === 'audio' || selectedType === 'text') {
                contentSection.style.display = 'block';
                fileSection.style.display = 'none';
                contentField.setAttribute('required', 'required');
                fileField.removeAttribute('required');
            } else {
                contentSection.style.display = 'none';
                fileSection.style.display = 'none';
            }
        }

        typeSelect.addEventListener('change', updateFieldVisibility);

        // Initialize on page load
        updateFieldVisibility();
    </script>
</x-app-layout>
