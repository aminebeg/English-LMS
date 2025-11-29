<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('courses.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Course Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between items-center">
                                <x-input-label for="description" :value="__('Description')" />
                                <button type="button" id="generate-description" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Generate with AI</button>
                            </div>
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
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
                                const originalText = button.innerText;
                                button.innerText = 'Generating...';
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
                                    button.innerText = originalText;
                                    button.disabled = false;
                                });
                            });
                        </script>

                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Course Type')" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="adult">Adult</option>
                                <option value="kid">Kid</option>
                                <option value="researcher">Researcher</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="level" :value="__('Level (Optional)')" />
                            <select id="level" name="level" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">No specific level</option>
                                <option value="A1">A1</option>
                                <option value="A2">A2</option>
                                <option value="B1">B1</option>
                                <option value="B2">B2</option>
                                <option value="C1">C1</option>
                                <option value="C2">C2</option>
                            </select>
                            <x-input-error :messages="$errors->get('level')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price', 0)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('courses.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Cancel
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Create Course') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
