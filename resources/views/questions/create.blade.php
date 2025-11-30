<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('tests.show', $test) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Test
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Add Question</h1>
                <p class="text-gray-600 dark:text-gray-400">Add a new question to <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $test->title }}</span></p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Gradient Top Border -->
                <div class="h-2 bg-gradient-to-r from-green-500 via-teal-500 to-blue-500"></div>

                <div class="p-8">
                    <form method="POST" action="{{ route('questions.store') }}" id="questionForm" class="space-y-6">
                        @csrf
                        <input type="hidden" name="test_id" value="{{ $test->id }}">

                        <!-- Question Content with AI -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question Text</label>
                                <button type="button" id="generate-question" 
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Generate with AI
                                </button>
                            </div>
                            <textarea id="content" name="content" rows="3" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm"
                                placeholder="e.g., What is the past tense of 'run'?">{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <!-- Question Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Type</label>
                            <select id="type" name="type" required onchange="updateQuestionType()"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
                                <option value="multiple_choice" {{ old('type') === 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="true_false" {{ old('type') === 'true_false' ? 'selected' : '' }}>True/False</option>
                                <option value="short_answer" {{ old('type') === 'short_answer' ? 'selected' : '' }}>Short Answer</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Multiple Choice Options -->
                        <div id="multipleChoiceSection" class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Answer Options</label>
                            <div id="optionsContainer" class="space-y-3">
                                @for($i = 0; $i < 4; $i++)
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-bold text-gray-400 w-6">{{ chr(65 + $i) }}.</span>
                                        <input type="text" name="options[]" value="{{ old('options.' . $i) }}" placeholder="Option {{ $i + 1 }}"
                                            class="flex-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
                                    </div>
                                @endfor
                            </div>
                            <button type="button" onclick="addOption()" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Another Option
                            </button>
                        </div>

                        <!-- True/False Section -->
                        <div id="trueFalseSection" class="hidden">
                            <label for="tf_answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correct Answer</label>
                            <select id="tf_answer" 
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
                                <option value="True">True</option>
                                <option value="False">False</option>
                            </select>
                        </div>

                        <!-- Correct Answer Field -->
                        <div>
                            <label for="correct_answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correct Answer</label>
                            <input type="text" id="correct_answer" name="correct_answer" value="{{ old('correct_answer') }}" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" id="answerHint">For multiple choice, enter the exact text of the correct option.</p>
                            <x-input-error :messages="$errors->get('correct_answer')" class="mt-2" />
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order</label>
                            <input type="number" id="order" name="order" value="{{ old('order', $test->questions->count() + 1) }}" required
                                class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('tests.show', $test) }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200">
                                Add Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateQuestionType() {
            const type = document.getElementById('type').value;
            const multipleChoiceSection = document.getElementById('multipleChoiceSection');
            const trueFalseSection = document.getElementById('trueFalseSection');
            const correctAnswerInput = document.getElementById('correct_answer');
            const answerHint = document.getElementById('answerHint');

            // Hide all sections first
            multipleChoiceSection.style.display = 'none';
            trueFalseSection.style.display = 'none';
            trueFalseSection.classList.add('hidden');

            // Show relevant section and update hint
            if (type === 'multiple_choice') {
                multipleChoiceSection.style.display = 'block';
                answerHint.textContent = 'Enter the exact text of the correct option.';
                correctAnswerInput.readOnly = false;
            } else if (type === 'true_false') {
                trueFalseSection.style.display = 'block';
                trueFalseSection.classList.remove('hidden');
                answerHint.textContent = 'Select True or False above.';
                correctAnswerInput.value = document.getElementById('tf_answer').value;
                correctAnswerInput.readOnly = true;
            } else {
                answerHint.textContent = 'Enter the expected answer for this question.';
                correctAnswerInput.readOnly = false;
                correctAnswerInput.value = '';
            }
        }

        function addOption() {
            const container = document.getElementById('optionsContainer');
            const index = container.children.length;
            const letter = String.fromCharCode(65 + index);
            
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3';
            div.innerHTML = `
                <span class="text-sm font-bold text-gray-400 w-6">${letter}.</span>
                <input type="text" name="options[]" placeholder="Option ${index + 1}"
                    class="flex-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 transition-shadow shadow-sm">
            `;
            container.appendChild(div);
        }

        // Update True/False answer when dropdown changes
        document.getElementById('tf_answer').addEventListener('change', function() {
            document.getElementById('correct_answer').value = this.value;
        });
        
        // AI Generation
        document.getElementById('generate-question').addEventListener('click', function() {
            const type = document.getElementById('type').value;
            const prompt = `Generate a ${type} question for an English test. Return ONLY the question text.`;
            
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
                    alert('Error generating question');
                }
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                button.innerHTML = originalContent;
                button.disabled = false;
            });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', updateQuestionType);
    </script>
</x-app-layout>
