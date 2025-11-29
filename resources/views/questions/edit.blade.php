<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Question') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('questions.update', $question) }}" id="questionForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Question')" />
                            <textarea id="content" name="content" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('content', $question->content) }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Question Type')" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required onchange="updateQuestionType()">
                                <option value="multiple_choice" {{ old('type', $question->type) === 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="true_false" {{ old('type', $question->type) === 'true_false' ? 'selected' : '' }}>True/False</option>
                                <option value="short_answer" {{ old('type', $question->type) === 'short_answer' ? 'selected' : '' }}>Short Answer</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Multiple Choice Options -->
                        <div id="multipleChoiceSection" class="mb-4">
                            <x-input-label :value="__('Answer Options')" />
                            <div id="optionsContainer" class="space-y-2 mt-2">
                                @if(old('options'))
                                    @foreach(old('options') as $option)
                                        <x-text-input type="text" name="options[]" :value="$option" placeholder="Option {{ $loop->iteration }}" class="block w-full" />
                                    @endforeach
                                @elseif($question->options)
                                    @foreach($question->options as $option)
                                        <x-text-input type="text" name="options[]" :value="$option" placeholder="Option {{ $loop->iteration }}" class="block w-full" />
                                    @endforeach
                                @else
                                    @for($i = 0; $i < 4; $i++)
                                        <x-text-input type="text" name="options[]" value="" placeholder="Option {{ $i + 1 }}" class="block w-full" />
                                    @endfor
                                @endif
                            </div>
                            <button type="button" onclick="addOption()" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">
                                + Add Another Option
                            </button>
                        </div>

                        <!-- True/False Section -->
                        <div id="trueFalseSection" class="mb-4" style="display: none;">
                            <x-input-label for="tf_answer" :value="__('Correct Answer')" />
                            <select id="tf_answer" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="True" {{ old('correct_answer', $question->correct_answer) === 'True' ? 'selected' : '' }}>True</option>
                                <option value="False" {{ old('correct_answer', $question->correct_answer) === 'False' ? 'selected' : '' }}>False</option>
                            </select>
                        </div>

                        <!-- Correct Answer -->
                        <div class="mb-4">
                            <x-input-label for="correct_answer" :value="__('Correct Answer')" />
                            <x-text-input id="correct_answer" class="block mt-1 w-full" type="text" name="correct_answer" :value="old('correct_answer', $question->correct_answer)" required />
                            <p class="text-xs text-gray-500 mt-1" id="answerHint">For multiple choice, enter the exact text of the correct option.</p>
                            <x-input-error :messages="$errors->get('correct_answer')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="order" :value="__('Order')" />
                            <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', $question->order)" required />
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('tests.show', $question->test) }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Cancel
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Update Question') }}
                            </x-primary-button>
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

            // Show relevant section and update hint
            if (type === 'multiple_choice') {
                multipleChoiceSection.style.display = 'block';
                answerHint.textContent = 'Enter the exact text of the correct option.';
            } else if (type === 'true_false') {
                trueFalseSection.style.display = 'block';
                answerHint.textContent = 'Enter "True" or "False".';
                correctAnswerInput.value = document.getElementById('tf_answer').value;
            } else {
                answerHint.textContent = 'Enter the expected answer for this question.';
            }
        }

        function addOption() {
            const container = document.getElementById('optionsContainer');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'options[]';
            input.placeholder = 'Option ' + (container.children.length + 1);
            input.className = 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full';
            container.appendChild(input);
        }

        // Update True/False answer when dropdown changes
        document.addEventListener('DOMContentLoaded', function() {
            const tfAnswer = document.getElementById('tf_answer');
            if (tfAnswer) {
                tfAnswer.addEventListener('change', function() {
                    document.getElementById('correct_answer').value = this.value;
                });
            }
            
            // Initialize the form based on selected type
            updateQuestionType();
        });
    </script>
</x-app-layout>
