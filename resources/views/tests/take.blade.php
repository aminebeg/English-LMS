<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $test->title }}
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Passing Score: {{ $test->passing_score }}%
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('tests.submit', $test) }}" id="testForm" onsubmit="return confirm('Are you sure you want to submit your answers?')">
                        @csrf
                        
                        <div class="space-y-8">
                            <x-input-error :messages="$errors->get('answers')" class="mb-4" />
                            
                            @foreach($questions as $index => $question)
                                <div class="border-b dark:border-gray-700 pb-6 last:border-0">
                                    <div class="flex items-start gap-3 mb-4">
                                        <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 font-bold text-sm">
                                            {{ $index + 1 }}
                                        </span>
                                        <div class="flex-grow">
                                            <h3 class="text-lg font-medium">{{ $question->content }}</h3>
                                        </div>
                                    </div>

                                    <div class="ml-11">
                                        @if($question->type === 'multiple_choice')
                                            <div class="space-y-3">
                                                @foreach($question->options as $option)
                                                    <label class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                        <input type="radio" 
                                                               name="answers[{{ $question->id }}]" 
                                                               value="{{ $option }}" 
                                                               class="form-radio h-5 w-5 text-indigo-600 transition duration-150 ease-in-out" 
                                                               required>
                                                        <span class="text-gray-700 dark:text-gray-300">{{ $option }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @elseif($question->type === 'true_false')
                                            <div class="space-y-3">
                                                <label class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                    <input type="radio" 
                                                           name="answers[{{ $question->id }}]" 
                                                           value="True" 
                                                           class="form-radio h-5 w-5 text-indigo-600 transition duration-150 ease-in-out" 
                                                           required>
                                                    <span class="text-gray-700 dark:text-gray-300">True</span>
                                                </label>
                                                <label class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                    <input type="radio" 
                                                           name="answers[{{ $question->id }}]" 
                                                           value="False" 
                                                           class="form-radio h-5 w-5 text-indigo-600 transition duration-150 ease-in-out" 
                                                           required>
                                                    <span class="text-gray-700 dark:text-gray-300">False</span>
                                                </label>
                                            </div>
                                        @elseif($question->type === 'short_answer')
                                            <div class="mt-2">
                                                <textarea name="answers[{{ $question->id }}]" 
                                                          rows="2" 
                                                          class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                                          placeholder="Type your answer here..." 
                                                          required></textarea>
                                            </div>
                                        @endif
                                        <x-input-error :messages="$errors->get('answers.'.$question->id)" class="mt-2" />
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 flex justify-end">
                            <x-primary-button type="submit" class="px-6 py-3 text-lg">
                                {{ __('Submit Test') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
