<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Edit Material') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('materials.update', $material) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="title" :value="__('Material Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $material->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="type" :value="__('Type')" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="video" {{ old('type', $material->type) === 'video' ? 'selected' : '' }}> Video</option>
                                <option value="text" {{ old('type', $material->type) === 'text' ? 'selected' : '' }}> Text</option>
                                <option value="audio" {{ old('type', $material->type) === 'audio' ? 'selected' : '' }}> Audio</option>
                                <option value="file" {{ old('type', $material->type) === 'file' ? 'selected' : '' }}> File</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="content" :value="__('Content (URL or Text)')" />
                            <textarea id="content" name="content" rows="6" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" {{ old('type', $material->type) === 'file' ? 'disabled' : '' }}>{{ old('content', $material->content) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">For video/audio, enter the URL. For text, enter the content. Leave blank for file uploads.</p>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        @if ($material->type === 'file')
                            <div>
                                <x-input-label for="current-file" :value="__('Current File')" />
                                <div class="mt-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $material->file_name }}</p>
                                            <p class="text-xs text-gray-500">{{ number_format($material->file_size / 1024, 1) }} KB</p>
                                        </div>
                                        <a href="{{ route('materials.download', $material) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors">Download</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <x-input-label for="file" :value="__('Replace File (Optional)')" />
                                <input id="file" class="block mt-1 w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" type="file" name="file" />
                                <p class="text-xs text-gray-500 mt-1">Leave blank to keep current file. Max size: 10MB </p>
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            </div>
                        @else
                            <div>
                                <x-input-label for="file" :value="__('Upload File')" />
                                <input id="file" class="block mt-1 w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" type="file" name="file" {{ old('type', $material->type) === 'file' ? 'required' : '' }} />
                                <p class="text-xs text-gray-500 mt-1">Max size: 10MB</p>
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                            </div>
                        @endif

                        <div class="flex items-center justify-end pt-4 border-t border-gray-100 gap-4">
                            <a href="{{ route('lessons.edit', $material->lesson) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                {{ __('Update Material') }}
                            </button>
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
                if(fileField) fileField.required = true;
            } else {
                contentField.disabled = false;
                if(fileField) fileField.required = false;
            }
        });
    </script>
</x-app-layout>