<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <a href="{{ route('courses.show', $test->course) }}" class="hover:text-indigo-600 hover:>{{ $test->course->title }}</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-font-medium">{{ $test->title }}</span>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text->{{ $test->title }}</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Manage questions for this {{ $test->type === 'final_exam' ? 'final exam' : 'quiz' }}
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('tests.results', $test) }}" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            View Results
                        </a>
                        <a href="{{ route('tests.edit', $test) }}" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Test
                        </a>
                        <a href="{{ route('courses.edit', $test->course) }}" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-text-sm font-medium rounded-lg hover:bg-gray-50 hover:bg-transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Course
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 bg-rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text->{{ $test->questions->count() }}</p>
                            <p class="text-xs text-gray-500">Questions</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 bg-rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text->{{ $test->passing_score }}%</p>
                            <p class="text-xs text-gray-500">Passing Score</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-amber-100 bg-amber-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-capitalize">{{ str_replace('_', ' ', $test->type ?? 'Quiz') }}</p>
                            <p class="text-xs text-gray-500">Type</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 bg-rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text->#{{ $test->order }}</p>
                            <p class="text-xs text-gray-500">Order</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Questions Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 bg->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text->Questions</h2>
                            <p class="text-sm text-gray-500">{{ $test->questions->count() }} question(s) in this test</p>
                        </div>
                        
                        <div class="flex gap-2" x-data="{ 
                            showAiModal: false, 
                            topic: '', 
                            count: 5, 
                            loading: false,
                            errorMessage: '',
                            hasApiKey: {{ config('services.cerebras.api_key') || auth()->user()->cerebras_api_key ? 'true' : 'false' }},
                            generate() {
                                if (!this.topic) {
                                    this.errorMessage = 'Please enter a topic';
                                    return;
                                }
                                this.errorMessage = '';
                                this.loading = true;
                                axios.post('{{ route('ai.generate-questions') }}', {
                                    test_id: {{ $test->id }},
                                    topic: this.topic,
                                    count: this.count,
                                    provider: 'cerebras'
                                })
                                .then(response => {
                                    alert(response.data.message);
                                    window.location.reload();
                                })
                                .catch(error => {
                                    console.error(error);
                                    this.errorMessage = error.response?.data?.error || error.message;
                                })
                                .finally(() => {
                                    this.loading = false;
                                });
                            }
                        }">
                            <button @click="showAiModal = true" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Generate with AI
                            </button>
                            
                            <a href="{{ route('questions.create', ['test' => $test->id]) }}" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Question
                            </a>

                            <!-- AI Modal -->
                            <div x-show="showAiModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="showAiModal" @click="showAiModal = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
                                    
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                    
                                    <div x-show="showAiModal" 
                                        x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        
                                        <div class="px-6 py-5 border-b border-gray-200">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 bg-rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-semibold text->Generate with AI</h3>
                                                    <p class="text-sm text-gray-500">Create questions automatically</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="px-6 py-5 space-y-4">
                                            <!-- API Key Warning -->
                                            <div x-show="!hasApiKey" class="p-4 bg-amber-50 bg-border border-amber-200 border-amber-800 rounded-lg">
                                                <div class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                    <div>
                                                        <h4 class="font-medium text-amber-800">API Key Required</h4>
                                                        <p class="text-sm text-amber-700 mt-1">You need to configure your Cerebras API key to use AI generation.</p>
                                                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-1 mt-2 text-sm font-medium text-amber-800 hover:underline">
                                                            Go to Profile Settings
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Error Message -->
                                            <div x-show="errorMessage" x-cloak class="p-4 bg-red-50 bg-red-900/20 border border-red-200 border-red-800 rounded-lg">
                                                <div class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-red-600 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <div>
                                                        <h4 class="font-medium text-red-800 text-red-300">Generation Error</h4>
                                                        <p class="text-sm text-red-700 text-red-400 mt-1" x-text="errorMessage"></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div x-show="hasApiKey">
                                                <div class="mb-4">
                                                    <label for="topic" class="block text-sm font-medium text-mb-2">Topic</label>
                                                    <input type="text" x-model="topic" id="topic" 
                                                        class="w-full rounded-lg border-gray-300 bg-text-white focus:border-purple-500 focus:ring-purple-500 shadow-sm" 
                                                        placeholder="e.g. Past Simple Tense, Vocabulary, Grammar">
                                                </div>
                                                <div>
                                                    <label for="count" class="block text-sm font-medium text-mb-2">Number of Questions</label>
                                                    <input type="number" x-model="count" id="count" min="1" max="10" 
                                                        class="w-full rounded-lg border-gray-300 bg-text-white focus:border-purple-500 focus:ring-purple-500 shadow-sm">
                                                    <p class="mt-1 text-xs text-gray-500">Maximum 10 questions per generation</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="px-6 py-4 bg-gray-50 bg-border-t border-gray-200 flex justify-end gap-3">
                                            <button @click="showAiModal = false; errorMessage = ''" type="button" 
                                                class="px-4 py-2 text-sm font-medium text-bg-white bg-border border-gray-300 rounded-lg hover:bg-gray-50 hover:bg-gray-600 transition-colors">
                                                Cancel
                                            </button>
                                            <button x-show="hasApiKey" @click="generate()" :disabled="loading" type="button" 
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                                <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <span x-text="loading ? 'Generating...' : 'Generate Questions'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questions List -->
                <div class="divide-y divide-gray-200 divide->
                    @forelse($test->questions->sortBy('order') as $question)
                        <div class="p-6 hover:bg-gray-50 hover:bg-transition-colors">
                            <div class="flex items-start gap-4">
                                <!-- Question Number -->
                                <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 bg-rounded-lg flex items-center justify-center">
                                    <span class="text-sm font-bold text-indigo-600">{{ $question->order }}</span>
                                </div>
                                
                                <!-- Question Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4 mb-3">
                                        <p class="text-font-medium">{{ $question->content }}</p>
                                        <div class="flex-shrink-0 flex items-center gap-2">
                                            <a href="{{ route('questions.edit', $question) }}" 
                                                class="p-2 hover:text-indigo-600 hover:hover:bg-indigo-50 hover:bg-rounded-lg transition-colors"
                                                title="Edit question">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('questions.destroy', $question) }}" onsubmit="return confirm('Delete this question?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="p-2 hover:text-red-600 hover:text-red-400 hover:bg-red-50 hover:bg-red-900/20 rounded-lg transition-colors"
                                                    title="Delete question">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Type Badge -->
                                    <div class="flex items-center gap-2 mb-3">
                                        @if($question->type === 'multiple_choice')
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 bg-blue-900/30 text-blue-700 text-xs font-medium rounded-md">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                                Multiple Choice
                                            </span>
                                        @elseif($question->type === 'true_false')
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 bg-text-emerald-700 text-xs font-medium rounded-md">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                True / False
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 bg-amber-900/30 text-amber-700 text-xs font-medium rounded-md">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Short Answer
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Options / Answer -->
                                    @if($question->type === 'multiple_choice' && $question->options)
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach($question->options as $index => $option)
                                                <div class="flex items-center gap-2 px-3 py-2 rounded-lg {{ $option === $question->correct_answer ? 'bg-emerald-50 bg-emerald-900/20 border border-emerald-200 border-emerald-800' : 'bg-gray-50 bg-gray-700/50' }}">
                                                    <span class="flex-shrink-0 w-6 h-6 rounded-full {{ $option === $question->correct_answer ? 'bg-emerald-500 text-white' : 'bg-gray-200 bg-gray-600 text-gray-600 text-gray-300' }} flex items-center justify-center text-xs font-bold">
                                                        {{ chr(65 + $index) }}
                                                    </span>
                                                    <span class="{{ $option === $question->correct_answer ? 'text-emerald-700 font-medium' : 'text-gray-600' }} text-sm">
                                                        {{ $option }}
                                                    </span>
                                                    @if($option === $question->correct_answer)
                                                        <svg class="w-4 h-4 text-emerald-500 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="inline-flex items-center gap-2 px-3 py-2 bg-emerald-50 bg-emerald-900/20 border border-emerald-200 border-emerald-800 rounded-lg">
                                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-sm text-emerald-700 font-medium">{{ $question->correct_answer }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 bg-rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-mb-2">No questions yet</h3>
                            <p class="text-gray-500 mb-6">Add questions to make this test available to students.</p>
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('questions.create', ['test' => $test->id]) }}" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add First Question
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>

