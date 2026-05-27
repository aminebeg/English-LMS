<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="{{ route('courses.show', $test->course) }}" class="hover:text-indigo-600 transition-colors">{{ $test->course->title }}</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('tests.show', $test) }}" class="hover:text-indigo-600 transition-colors">{{ $test->title }}</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-700 font-medium">Results</span>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Student Results</h1>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $test->title }} &bull; Passing score: {{ $test->passing_score }}%</p>
                    </div>
                    <a href="{{ route('tests.show', $test) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Test
                    </a>
                </div>
            </div>

            <!-- Stats Summary -->
            @if($results->isNotEmpty())
                @php
                    $passCount = $results->where('passed', true)->count();
                    $avgScore = round($results->avg('score'), 1);
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ $results->count() }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Total Attempts</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 text-center">
                        <p class="text-2xl font-bold text-emerald-600">{{ $passCount }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Passed</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 text-center col-span-2 sm:col-span-1">
                        <p class="text-2xl font-bold text-indigo-600">{{ $avgScore }}%</p>
                        <p class="text-xs text-gray-500 mt-0.5">Average Score</p>
                    </div>
                </div>
            @endif

            <!-- Results Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                @if ($results->isEmpty())
                    <div class="text-center py-16">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">No results yet</h3>
                        <p class="text-gray-500 text-sm">No students have taken this test yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Score</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($results as $result)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs flex-shrink-0">
                                                    {{ substr($result->user->name, 0, 1) }}
                                                </div>
                                                <span class="text-sm font-medium text-gray-900">{{ $result->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold {{ $result->passed ? 'text-emerald-600' : 'text-red-600' }}">
                                                {{ $result->score }}%
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($result->passed)
                                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Passed</span>
                                            @else
                                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-700">Failed</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $result->created_at->format('M d, Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
