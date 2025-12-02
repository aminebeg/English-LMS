<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $test->title }}
            </h2>
                <a href="{{ route('tests.results', $test) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    View Results
                </a>
                <a href="{{ route('tests.edit', $test) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Edit Test
                </a>
                <a href="{{ route('courses.edit', $test->course) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Back to Edit Course
                </a>
                <a href="{{ route('courses.show', $test->course) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    View Course
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Test Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Test Information</h3>
                    <p class="mb-2"><strong>Course:</strong> {{ $test->course->title }}</p>
                    <p class="mb-2"><strong>Passing Score:</strong> {{ $test->passing_score }}%</p>
                    <p class="mb-2"><strong>Order:</strong> {{ $test->order }}</p>
                    <p class="mb-2"><strong>Total Questions:</strong> {{ $test->questions->count() }}</p>
                </div>
            </div>

            <!-- Questions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Questions</h3>
                        <div class="flex gap-2" x-data="{ 
                            showAiModal: false, 
                            topic: '', 
                            count: 5, 
                            loading: false,
                            generate() {
                                if (!this.topic) return alert('Please enter a topic');
                                this.loading = true;
                                axios.post('{{ route('ai.generate-questions') }}', {
                                    test_id: {{ $test->id }},
                                    topic: this.topic,
                                    count: this.count
                                })
                                .then(response => {
                                    alert(response.data.message);
                                    window.location.reload();
                                })
                                .catch(error => {
                                    console.error(error);
                                    alert('Error generating questions: ' + (error.response?.data?.error || error.message));
                                })
                                .finally(() => {
                                    this.loading = false;
                                    this.showAiModal = false;
                                });
                            }
                        }">
                            <button @click="showAiModal = true" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                                Generate with AI ✨
                            </button>
                            <a href="{{ route('questions.create', ['test' => $test->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Add Question
                            </a>

                            <!-- AI Modal -->
                            <div x-show="showAiModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="showAiModal" @click="showAiModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                                        Generate Questions with AI
                                                    </h3>
                                                    <div class="mt-4 space-y-4">
                                                        <div>
                                                            <label for="topic" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Topic</label>
                                                            <input type="text" x-model="topic" id="topic" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g. Past Simple Tense">
                                                        </div>
                                                        <div>
                                                            <label for="count" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Questions</label>
                                                            <input type="number" x-model="count" id="count" min="1" max="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button @click="generate()" :disabled="loading" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                                                <span x-show="!loading">Generate</span>
                                                <span x-show="loading">Generating...</span>
                                            </button>
                                            <button @click="showAiModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($test->questions->isEmpty())
                        <p class="text-gray-500">No questions yet. Add questions to make this test available to students.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($test->questions->sortBy('order') as $index => $question)
                                <div class="border dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-semibold">Question {{ $question->order }}</h4>
                                        <div class="flex gap-2">
                                            <a href="{{ route('questions.edit', $question) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('questions.destroy', $question) }}" onsubmit="return confirm('Are you sure?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="mb-2">{{ $question->content }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Type: {{ ucfirst(str_replace('_', ' ', $question->type)) }}</p>
                                    
                                    @if($question->type === 'multiple_choice' && $question->options)
                                        <div class="ml-4 space-y-1">
                                            @foreach($question->options as $option)
                                                <div class="flex items-center">
                                                    <span class="mr-2">{{ $loop->iteration }}.</span>
                                                    <span class="{{ $option === $question->correct_answer ? 'text-green-600 dark:text-green-400 font-semibold' : '' }}">
                                                        {{ $option }}
                                                        @if($option === $question->correct_answer)
                                                            <span class="text-xs">(Correct)</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="ml-4 text-green-600 dark:text-green-400">
                                            <strong>Correct Answer:</strong> {{ $question->correct_answer }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
