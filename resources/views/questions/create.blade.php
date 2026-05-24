<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('tests.show', $test) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-indigo-600 text-gray-400 hover:text-indigo-400 mb-4 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Test
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Add New Question
                </h1>
                <p class="text-gray-600">Add a question to <span class="font-semibold text-indigo-600 text-indigo-400">{{ $test->title }}</span></p>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <form method="POST" action="{{ route('questions.store') }}" id="questionForm" class="p-8">
                    @csrf
                    <input type="hidden" name="test_id" value="{{ $test->id }}">

                    <!-- Question Type Selection -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-4">
                            Question Type
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="multiple_choice" class="peer sr-only" 
                                    {{ old('type', 'multiple_choice') === 'multiple_choice' ? 'checked' : '' }} onchange="updateQuestionType()">
                                <div class="p-4 rounded-lg border border-gray-200 hover:border-indigo-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:bg-indigo-900/20 transition-all text-center">
                                    <div class="text-2xl mb-2">📝</div>
                                    <div class="font-semibold text-gray-900">Multiple Choice</div>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="true_false" class="peer sr-only" 
                                    {{ old('type') === 'true_false' ? 'checked' : '' }} onchange="updateQuestionType()">
                                <div class="p-4 rounded-lg border border-gray-200 hover:border-indigo-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:bg-indigo-900/20 transition-all text-center">
                                    <div class="text-2xl mb-2">✅</div>
                                    <div class="font-semibold text-gray-900">True / False</div>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="short_answer" class="peer sr-only" 
                                    {{ old('type') === 'short_answer' ? 'checked' : '' }} onchange="updateQuestionType()">
                                <div class="p-4 rounded-lg border border-gray-200 hover:border-indigo-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:bg-indigo-900/20 transition-all text-center">
                                    <div class="text-2xl mb-2">✍️</div>
                                    <div class="font-semibold text-gray-900">Short Answer</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Question Content -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <label for="content" class="block text-sm font-medium text-gray-700">
                                Question Text <span class="text-red-500">*</span>
                            </label>
                            <button type="button" id="generate-question" 
                                class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 text-indigo-400 hover:text-indigo-700 hover:text-indigo-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Generate with AI
                            </button>
                        </div>
                        <textarea id="content" name="content" rows="3" required
                            class="w-full rounded-md border-gray-300 border-gray-700 bg-gray-900 text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-base"
                            placeholder="e.g., What is the past participle of 'go'?">{{ old('content') }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <!-- Multiple Choice Options -->
                    <div id="multipleChoiceSection" class="mb-8 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Answer Options
                        </label>
                        <div class="bg-gray-50 bg-gray-700/50 rounded-lg p-6 space-y-4 border border-gray-100 border-gray-700">
                            <div id="optionsContainer" class="space-y-3">
                                @for($i = 0; $i < 4; $i++)
                                    <div class="flex items-center gap-3 option-row">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 bg-indigo-900 text-indigo-600 text-indigo-400 flex items-center justify-center font-bold text-sm">
                                            {{ chr(65 + $i) }}
                                        </div>
                                        <input type="text" name="options[]" value="{{ old('options.' . $i) }}" placeholder="Option {{ $i + 1 }}"
                                            class="flex-1 rounded-md border-gray-300 border-gray-700 bg-gray-900 text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                        <input type="radio" name="correct_option_radio" value="{{ $i }}" 
                                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 cursor-pointer"
                                            onclick="setCorrectAnswer(this)"
                                            title="Mark as correct answer">
                                    </div>
                                @endfor
                            </div>
                            
                            <button type="button" onclick="addOption()" class="flex items-center gap-2 text-sm font-medium text-indigo-600 text-indigo-400 hover:text-indigo-800 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Another Option
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Click the radio button next to an option to mark it as the correct answer.</p>
                    </div>

                    <!-- True/False Section -->
                    <div id="trueFalseSection" class="mb-8 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Correct Answer
                        </label>
                        <div class="flex gap-4">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="tf_radio" value="True" class="peer sr-only" onchange="setTFAnswer('True')">
                                <div class="p-4 rounded-lg border border-gray-200 hover:border-green-500 peer-checked:border-green-600 peer-checked:bg-green-50 peer-checked:bg-green-900/20 transition-all text-center">
                                    <span class="font-bold text-lg text-green-700 text-green-400">True</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="tf_radio" value="False" class="peer sr-only" onchange="setTFAnswer('False')">
                                <div class="p-4 rounded-lg border border-gray-200 hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 peer-checked:bg-red-900/20 transition-all text-center">
                                    <span class="font-bold text-lg text-red-700 text-red-400">False</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Short Answer Section -->
                    <div id="shortAnswerSection" class="mb-8 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Correct Answer / Keywords
                        </label>
                        <input type="text" id="short_answer_input" 
                            class="w-full rounded-md border-gray-300 border-gray-700 bg-gray-900 text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                            placeholder="Enter the expected answer..."
                            oninput="document.getElementById('correct_answer').value = this.value">
                        <p class="mt-2 text-xs text-gray-500">Students must match this answer exactly (case-insensitive).</p>
                    </div>

                    <!-- Hidden Correct Answer Field -->
                    <input type="hidden" id="correct_answer" name="correct_answer" value="{{ old('correct_answer') }}">

                    <!-- Order -->
                    <div class="mb-8">
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                            Question Order
                        </label>
                        <input type="number" id="order" name="order" value="{{ old('order', $test->questions->count() + 1) }}" required min="1"
                            class="w-32 rounded-md border-gray-300 border-gray-700 bg-gray-900 text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('tests.show', $test) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 hover:text-white transition-colors">
                            Cancel
                        </a>

                        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition-colors shadow-sm">
                            Add Question
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
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 bg-indigo-900 text-indigo-600 text-indigo-400 flex items-center justify-center font-bold text-sm">
                    ${letter}
                </div>
                <input type="text" name="options[]" placeholder="Option ${index + 1}"
                    class="flex-1 rounded-md border-gray-300 border-gray-700 bg-gray-900 text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                <input type="radio" name="correct_option_radio" value="${index}" 
                    class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 cursor-pointer"
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

        // AI Generation
        document.getElementById('generate-question').addEventListener('click', function() {
            const type = document.querySelector('input[name="type"]:checked').value;
            const prompt = `Generate a challenging ${type} question for an English test. Return ONLY the question text.`;
            
            const button = this;
            const originalContent = button.innerHTML;
            button.innerHTML = '<svg class="animate-spin w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...';
            button.disabled = true;

            fetch('{{ route("ai.generate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ prompt: prompt, provider: 'cerebras' })
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
        document.addEventListener('DOMContentLoaded', function() {
            updateQuestionType();
        });
    </script>
</x-app-layout>

