<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Material') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('materials.update', $material) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Material Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title', $material->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Type')" />
                            <select id="type" name="type"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                required>
                                <option value="video" {{ old('type', $material->type) === 'video' ? 'selected' : '' }}>
                                    Video</option>
                                <option value="text" {{ old('type', $material->type) === 'text' ? 'selected' : '' }}>
                                    Text</option>
                                <option value="audio" {{ old('type', $material->type) === 'audio' ? 'selected' : '' }}>
                                    Audio</option>
                                <option value="file" {{ old('type', $material->type) === 'file' ? 'selected' : '' }}>
                                    File</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Content (URL or Text)')" />
                            <textarea id="content" name="content" rows="6"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                {{ old('type', $material->type) === 'file' ? 'disabled' : '' }}>{{ old('content', $material->content) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">For video/audio, enter the URL. For text, enter the
                                content. Leave blank for file uploads.</p>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        @if ($material->type === 'file')
                            <div class="mb-4">
                                <x-input-label for="current-file" :value="__('Current File')" />
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $material->file_name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ number_format($material->file_size / 1024, 1) }} KB</p>
                                        </div>
                                        <a href="{{ route('materials.download', $material) }}"
                                            class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Download</a>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <x-input-label for="file" :value="__('Replace File (Optional)')" />
                                <input id="file"
                                    class="block mt-1 w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-100"
                                    type="file" name="file" />
                                <p class="text-xs text-gray-500 mt-1">Leave blank to keep current file. Max size: 10MB
                                </p>
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            </div>
                        @else
                            <div class="mb-4">
                                <x-input-label for="file" :value="__('Upload File')" />
                                <input id="file"
                                    class="block mt-1 w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-100"
                                    type="file" name="file"
                                    {{ old('type', $material->type) === 'file' ? 'required' : '' }} />
                                <p class="text-xs text-gray-500 mt-1">Max size: 10MB</p>
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            </div>
                        @endif

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('lessons.edit', $material->lesson) }}"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Material') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle content textarea based on type
        document.getElementById('type').addEventListener('change', function() {
            const contentField = document.getElementById('content');
            const fileField = document.getElementById('file');

            if (this.value === 'file') {
                contentField.disabled = true;
                contentField.value = '';
                fileField.required = true;
            } else {
                contentField.disabled = false;
                fileField.required = false;
            }
        });
    </script>
</x-app-layout>
