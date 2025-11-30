<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('tests.show', $question->test) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Test
                </a>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                    Edit Question
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Refine your assessment question</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden">
                <!-- Gradient Top Border -->
                <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <form method="POST" action="{{ route('questions.update', $question) }}" id="questionForm" class="p-8">
                    @csrf
                    @method('PUT')

                    <!-- Question Type Selection -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                            Question Type
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="multiple_choice" class="peer sr-only" 
                                    {{ old('type', $question->type) === 'multiple_choice' ? 'checked' : '' }} onchange="updateQuestionType()">
                                <div class="p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20 transition-all text-center">
                                    <div class="text-2xl mb-2">📝</div>
                                    <div class="font-semibold text-gray-900 dark:text-white">Multiple Choice</div>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="true_false" class="peer sr-only" 
                                    {{ old('type', $question->type) === 'true_false' ? 'checked' : '' }} onchange="updateQuestionType()">
                                <div class="p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20 transition-all text-center">
                                    <div class="text-2xl mb-2">✅</div>
                                    <div class="font-semibold text-gray-900 dark:text-white">True / False</div>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="short_answer" class="peer sr-only" 
                                    {{ old('type', $question->type) === 'short_answer' ? 'checked' : '' }} onchange="updateQuestionType()">
                                <div class="p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20 transition-all text-center">
                                    <div class="text-2xl mb-2">✍️</div>
                                    <div class="font-semibold text-gray-900 dark:text-white">Short Answer</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Question Content -->
                    <div class="mb-8">
                        <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Question Text <span class="text-red-500">*</span>
                        </label>
                        <textarea id="content" name="content" rows="3" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-lg"
                            placeholder="e.g., What is the past participle of 'go'?">{{ old('content', $question->content) }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <!-- Multiple Choice Options -->
                    <div id="multipleChoiceSection" class="mb-8 hidden">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Answer Options
                        </label>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 space-y-4">
                            <div id="optionsContainer" class="space-y-3">
                                @php
                                    $options = old('options', $question->options ?? ['', '', '', '']);
                                    // Ensure at least 4 options for UI consistency if empty
                                    if (empty($options)) $options = ['', '', '', ''];
                                @endphp
                                
                                @foreach($options as $index => $option)
                                    <div class="flex items-center gap-3 option-row">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                                            {{ chr(65 + $index) }}
                                        </div>
                                        <input type="text" name="options[]" value="{{ $option }}" placeholder="Option {{ $index + 1 }}"
                                            class="flex-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                        <input type="radio" name="correct_option_radio" value="{{ $index }}" 
                                            class="w-5 h-5 text-green-600 focus:ring-green-500 border-gray-300 cursor-pointer"
                                            onclick="setCorrectAnswer(this)"
                                            title="Mark as correct answer">
                                    </div>
                                @endforeach
                            </div>
                            
                            <button type="button" onclick="addOption()" class="flex items-center gap-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Another Option
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Click the radio button next to an option to mark it as the correct answer.</p>
                    </div>

                    <!-- True/False Section -->
                    <div id="trueFalseSection" class="mb-8 hidden">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Correct Answer
                        </label>
                        <div class="flex gap-4">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="tf_radio" value="True" class="peer sr-only" onchange="setTFAnswer('True')">
                                <div class="p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-green-500 peer-checked:border-green-600 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 transition-all text-center">
                                    <span class="font-bold text-lg text-green-700 dark:text-green-400">True</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="tf_radio" value="False" class="peer sr-only" onchange="setTFAnswer('False')">
                                <div class="p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 transition-all text-center">
                                    <span class="font-bold text-lg text-red-700 dark:text-red-400">False</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Short Answer Section -->
                    <div id="shortAnswerSection" class="mb-8 hidden">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Correct Answer / Keywords
                        </label>
                        <input type="text" id="short_answer_input" 
                            class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            placeholder="Enter the expected answer..."
                            oninput="document.getElementById('correct_answer').value = this.value">
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Students must match this answer exactly (case-insensitive).</p>
                    </div>

                    <!-- Hidden Correct Answer Field -->
                    <input type="hidden" id="correct_answer" name="correct_answer" value="{{ old('correct_answer', $question->correct_answer) }}">

                    <!-- Order -->
                    <div class="mb-8">
                        <label for="order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Question Order
                        </label>
                        <input type="number" id="order" name="order" value="{{ old('order', $question->order) }}" required min="1"
                            class="w-32 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('tests.show', $question->test) }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            Cancel
                        </a>

                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-200">
                            💾 Update Question
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateQuestionType() {
            const type = document.querySelector('input[name="type"]:checked').value;
            const multipleChoiceSection = document.getElementById('multipleChoiceSection');
            const trueFalseSection = document.getElementById('trueFalseSection');
            const shortAnswerSection = document.getElementById('shortAnswerSection');

            // Hide all
            multipleChoiceSection.classList.add('hidden');
            trueFalseSection.classList.add('hidden');
            shortAnswerSection.classList.add('hidden');

            // Show selected
            if (type === 'multiple_choice') {
                multipleChoiceSection.classList.remove('hidden');
                matchCorrectOption();
            } else if (type === 'true_false') {
                trueFalseSection.classList.remove('hidden');
                matchTFAnswer();
            } else {
                shortAnswerSection.classList.remove('hidden');
                document.getElementById('short_answer_input').value = document.getElementById('correct_answer').value;
            }
        }

        function addOption() {
            const container = document.getElementById('optionsContainer');
            const index = container.children.length;
            const letter = String.fromCharCode(65 + index);
            
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 option-row';
            div.innerHTML = `
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                    ${letter}
                </div>
                <input type="text" name="options[]" placeholder="Option ${index + 1}"
                    class="flex-1 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                <input type="radio" name="correct_option_radio" value="${index}" 
                    class="w-5 h-5 text-green-600 focus:ring-green-500 border-gray-300 cursor-pointer"
                    onclick="setCorrectAnswer(this)"
                    title="Mark as correct answer">
            `;
            container.appendChild(div);
        }

        function setCorrectAnswer(radio) {
            const index = radio.value;
            const inputs = document.getElementsByName('options[]');
            if (inputs[index]) {
                document.getElementById('correct_answer').value = inputs[index].value;
            }
            
            // Add listener to update correct answer if the text changes
            inputs[index].addEventListener('input', function() {
                if (radio.checked) {
                    document.getElementById('correct_answer').value = this.value;
                }
            });
        }

        function setTFAnswer(val) {
            document.getElementById('correct_answer').value = val;
        }

        function matchCorrectOption() {
            const currentCorrect = document.getElementById('correct_answer').value;
            const inputs = document.getElementsByName('options[]');
            const radios = document.getElementsByName('correct_option_radio');
            
            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].value === currentCorrect && currentCorrect !== '') {
                    radios[i].checked = true;
                    // Re-attach listener
                    inputs[i].addEventListener('input', function() {
                        if (radios[i].checked) {
                            document.getElementById('correct_answer').value = this.value;
                        }
                    });
                }
            }
        }

        function matchTFAnswer() {
            const currentCorrect = document.getElementById('correct_answer').value;
            const radios = document.getElementsByName('tf_radio');
            for (let radio of radios) {
                if (radio.value === currentCorrect) {
                    radio.checked = true;
                }
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateQuestionType();
        });
    </script>
</x-app-layout>
