<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                    <a href="{{ route('enrollments.show', $course) }}" class="hover:text-indigo-600 transition-colors">{{ $course->title }}</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-700 font-medium">{{ $test->title }}</span>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ $test->title }}</h1>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $questions->count() }} questions &bull; Passing score: {{ $test->passing_score }}%</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide
                        {{ $test->type === 'final_exam' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ $test->type === 'final_exam' ? 'Final Exam' : 'Quiz' }}
                    </span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div id="progress-bar-container" class="mb-6 bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                <div class="flex items-center justify-between text-xs font-semibold text-gray-500 mb-2">
                    <span>Progress</span>
                    <span id="progress-text">0 / {{ $questions->count() }} answered</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div id="progress-fill" class="bg-indigo-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <form method="POST" action="{{ route('tests.submit', $test) }}" id="testForm">
                @csrf

                <div class="space-y-5">
                    @foreach ($questions as $index => $question)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden question-card" data-index="{{ $index }}">
                            <!-- Question Header -->
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                                <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 font-bold text-sm flex items-center justify-center">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $question->content }}</p>
                                </div>
                                <span id="check-{{ $index }}" class="flex-shrink-0 hidden">
                                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </div>

                            <!-- Answer Options -->
                            <div class="p-4">
                                @if ($question->type === 'multiple_choice')
                                    <div class="space-y-2">
                                        @foreach ($question->options as $optIndex => $option)
                                            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 cursor-pointer hover:border-indigo-300 hover:bg-indigo-50 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                                <input type="radio" name="answers[{{ $question->id }}]"
                                                    value="{{ $option }}"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                                    onchange="markAnswered({{ $index }})"
                                                    required>
                                                <span class="flex-shrink-0 w-7 h-7 rounded-full bg-gray-100 text-gray-600 font-bold text-xs flex items-center justify-center">{{ chr(65 + $optIndex) }}</span>
                                                <span class="text-gray-800 text-sm font-medium">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                @elseif($question->type === 'true_false')
                                    <div class="grid grid-cols-2 gap-3">
                                        <label class="flex items-center justify-center gap-2 p-4 rounded-lg border border-gray-200 cursor-pointer hover:border-emerald-300 hover:bg-emerald-50 transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                                            <input type="radio" name="answers[{{ $question->id }}]"
                                                value="True"
                                                class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500"
                                                onchange="markAnswered({{ $index }})"
                                                required>
                                            <span class="font-bold text-emerald-700">✓ True</span>
                                        </label>
                                        <label class="flex items-center justify-center gap-2 p-4 rounded-lg border border-gray-200 cursor-pointer hover:border-red-300 hover:bg-red-50 transition-all has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                            <input type="radio" name="answers[{{ $question->id }}]"
                                                value="False"
                                                class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500"
                                                onchange="markAnswered({{ $index }})"
                                                required>
                                            <span class="font-bold text-red-700">✗ False</span>
                                        </label>
                                    </div>

                                @elseif($question->type === 'short_answer')
                                    <div>
                                        <textarea name="answers[{{ $question->id }}]" rows="2"
                                            class="block w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                            placeholder="Type your answer here..."
                                            oninput="markAnswered({{ $index }})"
                                            required></textarea>
                                        <p class="mt-1.5 text-xs text-gray-400">Answer is case-insensitive</p>
                                    </div>
                                @endif

                                <x-input-error :messages="$errors->get('answers.' . $question->id)" class="mt-2" />
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Submit Footer -->
                <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="text-sm text-gray-500">
                        <span id="unanswered-text" class="font-medium text-amber-600">Answer all questions before submitting.</span>
                    </div>
                    <button type="button" onclick="submitTest()" id="submit-btn"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-semibold rounded-lg transition-colors shadow-sm text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Submit Test
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const totalQuestions = {{ $questions->count() }};
        const answered = new Set();

        function markAnswered(index) {
            answered.add(index);
            updateProgress();

            // Show check mark
            const check = document.getElementById('check-' + index);
            if (check) check.classList.remove('hidden');
        }

        function updateProgress() {
            const count = answered.size;
            const pct = totalQuestions > 0 ? (count / totalQuestions) * 100 : 0;

            document.getElementById('progress-fill').style.width = pct + '%';
            document.getElementById('progress-text').textContent = count + ' / ' + totalQuestions + ' answered';

            const allAnswered = count >= totalQuestions;
            document.getElementById('unanswered-text').textContent = allAnswered
                ? 'All questions answered. Ready to submit!'
                : (totalQuestions - count) + ' question(s) remaining.';
            document.getElementById('unanswered-text').className = allAnswered
                ? 'font-medium text-emerald-600'
                : 'font-medium text-amber-600';
        }

        function submitTest() {
            if (answered.size < totalQuestions) {
                const remaining = totalQuestions - answered.size;
                if (!confirm('You still have ' + remaining + ' unanswered question(s). Submit anyway?')) {
                    return;
                }
            } else {
                if (!confirm('Are you sure you want to submit your answers?')) {
                    return;
                }
            }
            document.getElementById('testForm').submit();
        }
    </script>
</x-app-layout>
